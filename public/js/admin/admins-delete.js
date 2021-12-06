function submitDeleteForm()
{
  $("#deleteForm").submit();
}

function deleteAdmin(id)
{
  var id = id;
  var url = '/admin/admins/:id';
  url = url.replace(':id', id);
  $("#deleteForm").attr('action', url);
}

function deletePodcast(id)
{
  var id = id;
  var url = '/admin/podcasts/:id';
  url = url.replace(':id', id);
  $("#deleteForm").attr('action', url);
}
