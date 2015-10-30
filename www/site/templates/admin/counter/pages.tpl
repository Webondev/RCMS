<form action="" method="get">
от <input type="text" name="from" value="{$data.from}"> 
до <input type="text" name="to" value="{$data.to}"> 
<select name="limit">
	<option >40</option>
	<option >60</option>
	<option >80</option>
</select>
<input type="submit" value="Фильтровать">
</form>
<table>
<tr>
	<th>Хиты: {$data.hits}</th>
	<th>Хосты: {$data.hosts}</th>
	<th></th>
<tr>
<tr>
	<th>Date</th>
	<th>url</th>
	<th>hits</th>
	<th>hosts</th>
	<th></th>
<tr>
{foreach from=$list item=item}
<tr>
	<td>{$item.date}</td>
	<td><a href="{$item.url}" target="_blank">{$item.url}</a></td>
	<td>{$item.hits}</td>
	<td>{$item.hosts}</td>
	<td></td>
</tr>
{/foreach}
</table>
{$pages}