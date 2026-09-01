
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #4aa33c, #21bb16);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            background-color: white;
            width: 90%;
            max-width: 500px;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);

            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        form::before {
            content: "Deja tu comentario";
            font-size: 25px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 15px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #444;
            margin-top: 10px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #33a03f;
            box-shadow: 0 0 5px rgba(50, 137, 73, 0.64);
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        input[type="submit"],
        input[type="reset"] {
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        input[type="submit"] {
            background-color: #10d710;
            color: white;
        }

        input[type="submit"]:hover {
            background-color: #12b92d;
            transform: translateY(-2px);
        }

        input[type="reset"] {
            background-color: #eeeeee;
            color: #444;
        }

        input[type="reset"]:hover {
            background-color: #dcdcdc;
        }

        @media (max-width: 500px) {
            form {
                padding: 25px;
            }

            form::before {
                font-size: 21px;
            }
        }
    </style>
</head>
<body>
    <form action="coment.php" method="POST">
        <label for="asu">ASUNTO</label>
        <input type="text" name="asu" id="asu" placeholder="Escribe el asunto...">
        <label for="come">COMENTARIO</label>
        <textarea name="come" id="come" placeholder="Escribe tu comentario..."></textarea>
        <input type="submit" value="ENVIAR">
        <input type="reset" value="BORRAR">
    </form>
</body>
</html>

