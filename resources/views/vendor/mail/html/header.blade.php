@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === config('app.name'))
<img src="https://pmcn.gestaohouse.com.br/assets/img/logo-gesao-house-png.png" class="logo" alt="Gestão House Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
