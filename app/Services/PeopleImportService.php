<?php
namespace App\Services;

use App\Models\People;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PeopleImportService
{
    protected $errors = [];
    protected $imported = 0;
    protected $skipped = 0;
    protected $updated = 0;

    public function importFromCsv($filePath, $skipFirstRow = true)
    {
        $this->resetCounters();

        if (!file_exists($filePath)) {
            throw new \Exception("Arquivo não encontrado: {$filePath}");
        }

        $existingPeopleByCpf = People::all()->keyBy('cpf');

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \Exception("Erro ao abrir o arquivo CSV");
        }

        $rowNumber = 0;

        if ($skipFirstRow) {
            fgetcsv($handle, 0, ',');
            $rowNumber++;
        }

        while (($data = fgetcsv($handle, 0, ',')) !== FALSE) {
            $rowNumber++;
            $this->processRow($data, $rowNumber, $existingPeopleByCpf);
        }

        fclose($handle);

        return [
            'imported' => $this->imported,
            'updated' => $this->updated,
            'skipped' => $this->skipped,
            'errors' => $this->errors,
            'total_rows' => $rowNumber - ($skipFirstRow ? 1 : 0)
        ];
    }

    protected function processRow($data, $rowNumber, $existingPeopleByCpf = [])
    {
        try {
            $personData = $this->mapCsvData($data);
            $validator = $this->validatePersonData($personData);

            if ($validator->fails()) {
                $this->errors[] = [
                    'row' => $rowNumber,
                    'errors' => $validator->errors()->toArray(),
                    'data' => $personData
                ];
                $this->skipped++;
                return;
            }

            if (!empty($personData['cpf']) && isset($existingPeopleByCpf[$personData['cpf']])) {
                $existingPerson = $existingPeopleByCpf[$personData['cpf']];
                $this->updateExistingPerson($existingPerson, $personData, $rowNumber);
                return;
            }

            // Pessoa nova
            People::create($personData);
            $this->imported++;
            Log::info("Pessoa importada com sucesso", ['row' => $rowNumber, 'nome' => $personData['nome']]);

        } catch (\Exception $e) {
            $this->errors[] = [
                'row' => $rowNumber,
                'errors' => ['exception' => [$e->getMessage()]],
                'data' => $data
            ];
            $this->skipped++;

            Log::error("Erro ao importar linha {$rowNumber}", [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
        }
    }

    protected function updateExistingPerson($existingPerson, $personData, $rowNumber)
    {
        $changed = false;

        foreach ($personData as $key => $value) {
            $current = $existingPerson->$key;

            // Normalização: trata vazios como null
            $value = $value === '' ? null : $value;
            $current = $current === '' ? null : $current;

            // Para datas, padroniza formato
            if ($key === 'data_nascimento' && $current && $value) {
                $current = Carbon::parse($current)->format('Y-m-d');
                $value = Carbon::parse($value)->format('Y-m-d');
            }

            if ($current !== $value) {
                $existingPerson->$key = $value;
                $changed = true;
            }
        }

        if ($changed) {
            $existingPerson->save();
            $this->updated++;
            Log::info("Pessoa atualizada com sucesso", ['row' => $rowNumber, 'cpf' => $personData['cpf']]);
        } else {
            $this->skipped++;
        }
    }

    protected function mapCsvData($data)
    {
        return [
            'nome' => trim($data[1] ?? ''),
            'apelido' => trim($data[2] ?? ''),
            'cpf' => $this->cleanCpf($data[3] ?? ''),
            'whatsapp' => $this->cleanPhone($data[4] ?? ''),
            'genero' => trim($data[5] ?? ''),
            'escolaridade' => trim($data[6] ?? ''),
            'data_nascimento' => $this->parseDate($data[7] ?? ''),
            'rua' => trim($data[8] ?? ''),
            'numero' => trim($data[9] ?? ''),
            'bairro' => trim($data[10] ?? ''),
            'cidade' => trim($data[11] ?? ''),
            'cep' => trim($data[12] ?? ''),
            'uf' => strtoupper(trim($data[13] ?? '')),
            'latitude' => null,
            'longitude' => null,
            'geocoded_at' => null,
            'complemento' => trim($data[14] ?? ''),
        ];
    }

    protected function validatePersonData($data)
    {
        return Validator::make($data, [
            'nome' => 'required|string|max:255',
            'apelido' => 'nullable|string|max:50',
            'cpf' => 'required|string|size:11',
            'whatsapp' => 'nullable|string|max:20',
            'genero' => 'nullable|string|in:Masculino,Feminino',
            'escolaridade' => 'nullable|string',
            'data_nascimento' => ['nullable', 'date', 'before:today'],
            'rua' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:10',
            'bairro' => 'nullable|string|max:50',
            'cidade' => 'nullable|string|max:50',
            'cep' => 'nullable|string',
            'uf' => 'nullable|string',
            'geocoded_at' => 'nullable|date',
            'complemento' => 'nullable|max:255',
        ]);
    }

    protected function cleanCpf($cpf)
    {
        return preg_replace('/[^0-9]/', '', $cpf);
    }

    protected function cleanPhone($phone)
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }

    protected function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            $formats = ['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y', 'm-d-Y'];

            foreach ($formats as $format) {
                $parsed = Carbon::createFromFormat($format, $date);
                if ($parsed !== false) {
                    return $parsed->format('Y-m-d');
                }
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function resetCounters()
    {
        $this->errors = [];
        $this->imported = 0;
        $this->skipped = 0;
        $this->updated = 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getImported()
    {
        return $this->imported;
    }

    public function getSkipped()
    {
        return $this->skipped;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
}
