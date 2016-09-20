<!DOCTYPE html>
<html>
<head>
	<title>test</title>
</head>
<body>

	<table >
		@foreach ($lists as $list)
		<tr>
			<td><img src="{!! base_path().$list['photo_path'] !!}" width="50" heigh="50"></td>		
		</tr>
		@endforeach
	</tbody>
	</table>
</body>
</html>