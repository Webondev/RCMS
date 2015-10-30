<table>
<tr>
	<th>id</th>
	<th>name</th>
	<th>url</th>
	<th>status</th>
	<th></th>
	<th>edit</th>
	<th>del</th>
<tr>
{foreach from=$list item=item}
<tr>
	<td>{$item.id}</td>
	<td>{$item.name}</td>
	<td>{$item.url}</td>
	<td>{$this->status_list[$item.status]}</td>
	<td></td>
	<td><a href="edit/?id={$item.id}">Edit</a></td>
	<td><a href="del/?id={$item.id}">Del</a></td>
</tr>
{/foreach}
</table>
{$pages}