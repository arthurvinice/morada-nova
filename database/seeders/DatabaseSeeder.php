<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ChangelogCategory;
use App\Models\Department;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\People;
use App\Models\Order;
use App\Models\Terms;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    protected static ?string $password;


    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Arthur Vinícius',
            'nivel' => 'SuperAdmin',
            'is_ativo' => true,
            'email' => 'arthurvinice@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'departamento_id' => null,
        ]);

        ChangelogCategory::factory()->createMany([
            ['nome' => 'Correção de Bug'],
            ['nome' => 'Nova Funcionalidade'],
            ['nome' => 'Melhoria de Performance'],
            ['nome' => 'Atualização de Segurança'],
            ['nome' => 'Mudança na Interface'],
        ]);

        Terms::factory()->create([
            'term' => 'TERMO DE USO DO SISTEMA DE APOSTAS ACADÊMICO
                1. OBJETIVO DO SISTEMA

                Este sistema tem caráter estritamente acadêmico e educacional, sendo desenvolvido com a finalidade de estudos, aprendizagem e prática de conceitos de programação, banco de dados, interfaces web e lógica de sistemas, no âmbito de atividades escolares do Instituto Federal do Rio Grande do Norte (IFRN).

                Não se trata de uma plataforma de apostas real, comercial ou financeira.

                2. NATUREZA FICTÍCIA DAS APOSTAS

                Todas as apostas, valores, pontuações, créditos ou recompensas apresentadas no sistema são totalmente fictícias, não envolvendo:

                Dinheiro real

                Prêmios financeiros

                Bens materiais

                Qualquer forma de remuneração ou ganho econômico

                O sistema não realiza transações financeiras, não utiliza meios de pagamento e não gera qualquer tipo de lucro.

                3. PÚBLICO-ALVO

                O uso do sistema é restrito a:

                Estudantes

                Professores

                Avaliadores

                Participantes autorizados de projetos acadêmicos

                Todos vinculados às atividades educacionais do IFRN.

                4. FINALIDADE EDUCACIONAL

                O sistema é utilizado para:

                Simulação de cenários

                Aprendizado de lógica de sistemas

                Desenvolvimento de habilidades técnicas

                Demonstração de funcionalidades de software

                Não possui qualquer vínculo com casas de apostas, jogos de azar ou plataformas de betting reais.

                5. RESPONSABILIDADES DO USUÁRIO

                Ao utilizar o sistema, o usuário compromete-se a:

                Utilizá-lo exclusivamente para fins acadêmicos

                Não tentar adaptar ou divulgar o sistema como uma plataforma real de apostas

                Não inserir informações falsas que possam caracterizar fraude ou uso indevido

                Respeitar as normas institucionais do IFRN

                6. LIMITAÇÕES DE RESPONSABILIDADE

                Os desenvolvedores e o IFRN não se responsabilizam por:

                Uso indevido do sistema fora do contexto educacional

                Interpretação equivocada da finalidade do projeto

                Qualquer tentativa de utilização comercial ou financeira

                7. PROIBIÇÕES

                É expressamente proibido:

                Utilizar o sistema para apostas reais

                Associar o sistema a plataformas de jogos de azar

                Utilizar o sistema para fins comerciais

                Reproduzir ou redistribuir o sistema sem autorização acadêmica

                8. DIREITOS AUTORAIS E PROPRIEDADE INTELECTUAL

                O sistema é um projeto acadêmico, e seu código, layout e funcionalidades destinam-se apenas a fins educacionais.
                Qualquer reutilização deve respeitar os direitos autorais e as normas institucionais.

                9. ALTERAÇÕES NO TERMO DE USO

                Este Termo de Uso pode ser alterado a qualquer momento para adequação a normas acadêmicas, legais ou institucionais, sem aviso prévio.

                10. ACEITE DOS TERMOS

                Ao acessar ou utilizar este sistema, o usuário declara que:

                Leu

                Compreendeu

                Concorda integralmente com este Termo de Uso

                Reconhecendo seu caráter exclusivamente acadêmico e fictício.',
            'version' => '1.0',
        ]);

    }
}
