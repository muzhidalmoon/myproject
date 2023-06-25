let table = new DataTable('#myTable');
let edit = document.querySelectorAll('.edit');
Array.from(edit).forEach(function(edit){
  edit.addEventListener('click',function(e){
    let tr = e.target.parentNode.parentNode;
    let title = tr.querySelectorAll('td')[0];
    let description = tr.querySelectorAll('td')[1];
    $('#editModal').modal('toggle')
    document.getElementById('titleEdit').value = title.innerText;
    document.getElementById('snoEdit').value = e.target.id;
    document.getElementById('descriptionEdit').innerText = description.innerText;
  })
})
let deleteData = document.querySelectorAll('.delete');
Array.from(deleteData).forEach(function(deleteData){
  deleteData.addEventListener('click',function(e){
    let sno = e.target.id;
    if(confirm('Confirm to delete')){
        window.location = `crud.php?delete=${sno}`;
    }
  })
})