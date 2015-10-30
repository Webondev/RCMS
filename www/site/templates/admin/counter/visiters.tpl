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
	<th>Date</th>
	<th>ip</th>
	<th>data</th>
	<th>bot</th>
	<th></th>
<tr>
{foreach from=$list item=item}
<tr>
	<td>{$item.date}</td>
	<td><a href="{$item.url}" target="_blank">{long2ip($item.ip)}</a></td>
	<td>{$item.http_user_agent}</td>
	<td>{$item.is_bot}</td>
	<td></td>
</tr>
{/foreach}
</table>
{$pages}