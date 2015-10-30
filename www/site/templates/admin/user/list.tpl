<table>
<tr>
	<th>id</ht>
	<th>Login</ht>
	<th>Email</ht>
	<th>edit</ht>
<tr>
{foreach from=$list item=item}
<tr>
	<td>{$item.id}</td>
	<td>{$item.login}</td>
	<td>{$item.email}</td>
	<td><a href="{$ADMIN_URL}user/edit?id={$item.id}">Edit</a></td>
</tr>
{/foreach}
</table>