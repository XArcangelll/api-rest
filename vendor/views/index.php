<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" id="form">
            <input type="text" name="id">
            <input type="text" name="nombres">
            <input type="text" name="apellidos">
            <input type="submit" value="futuro">
    </form>

    <script>

        const form = document.getElementById("form");

        form.addEventListener("submit",e=>{
            //si quieres elimina el const data y el header application json
                e.preventDefault();
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
        const options = {
            method: "DELETE",
           headers: {
           "Content-Type": "application/json",
    },
    body: JSON.stringify(data)
        }
        fetch("http://localhost/api-rest/alumnos/",options).then(res=> res.json()).then(data => console.log(data));
        });

    </script>    
</body>
</html>

