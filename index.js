 let edit = document.getElementsByClassName('edit')
 Array.from(edit).forEach((element) => {
     element.addEventListener('click', (e) => {

         let tr = e.target.parentNode.parentNode;

         let title = tr.getElementsByTagName('td')[0].innerText
         let description = tr.getElementsByTagName('td')[1].innerText

         edittitle.value = title
         editdescription.value = description
         snoEdit.value = e.target.id;
         console.log(e.target.id);
         $('#editModal').modal('toggle')

     });
 })

 let del = document.getElementsByClassName('delete')
 Array.from(del).forEach((element) => {
     element.addEventListener('click', (e) => {

         sno = e.target.id.substr(0, );
         if (confirm("Do you want to delete this note?")) {

             window.location = `index.php?delete=${sno}`;

         } else {
             console.log("no");
         }


     });
 })