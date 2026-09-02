
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>

    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    body {
        font-family: Arial, Helvetica, sans-serif;
        min-height: 100vh;
        background: #f7f3ed;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
        position: relative;
        overflow: hidden;
    }
    body::before {
        content: "";
        position: fixed;
        width: 380px;
        height: 380px;
        background: #10a94b;
        border-radius: 50%;
        top: -180px;
        left: -150px;
        opacity: 0.12;
    }
    body::after {
        content: "";
        position: fixed;
        width: 420px;
        height: 420px;
        background: #f9c98f;
        border-radius: 50%;
        bottom: -230px;
        right: -170px;
        opacity: 0.35;
    }
    form {
        width: 100%;
        max-width: 620px;
        background: #10a94b;
        padding: 45px;
        border-radius: 30px;
        position: relative;
        z-index: 2;
        box-shadow: 0 25px 60px rgba(35, 55, 35, 0.18);
        display: flex;
        flex-direction: column;
        gap: 9px;
        overflow: hidden;
    }
    form::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        background: rgba(255, 255, 255, 0.07);
        border-radius: 50%;
        top: -100px;
        right: -70px;
        pointer-events: none;
    }
    form::before {
        content: "Cuéntanos tu experiencia";
        font-size: clamp(30px, 5vw, 44px);
        line-height: 0.95;
        font-weight: 900;
        color: white;
        margin-bottom: 8px;
        max-width: 450px;
        letter-spacing: -1.5px;
        position: relative;
        z-index: 2;
    }
    form {
        --label-bg: #f9c98f;
    }

    form > label:first-of-type::before {
        content: "●";
        color: #10a94b;
        background: #f9c98f;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin-right: 8px;
        font-size: 9px;
    }
    label {
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1.2px;
        color: white;
        margin-top: 15px;
        position: relative;
        z-index: 2;
    }
    input[type="text"],
    textarea {
        width: 100%;
        padding: 15px 17px;
        border: 2px solid transparent;
        border-radius: 13px;
        background: #087f38;
        color: white;
        font-size: 15px;
        font-family: inherit;
        outline: none;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }
    input[type="text"]::placeholder,
    textarea::placeholder {
        color: rgba(255, 255, 255, 0.65);
    }
    input[type="text"]:focus,
    textarea:focus {
        background: #076e31;
        border-color: #f9c98f;
        box-shadow: 0 0 0 4px rgba(249, 201, 143, 0.18);
    }
    textarea {
        min-height: 170px;
        resize: vertical;
        line-height: 1.5;
    }
    input[type="submit"],
    input[type="reset"] {
        width: 100%;
        padding: 15px 20px;
        border: none;
        border-radius: 13px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.25s ease;
        position: relative;
        z-index: 2;
        margin-top: 12px;
    }
    input[type="submit"] {
        background: #f9c98f;
        color: #3a2119;
        box-shadow: 0 6px 0 #e5ad70;
    }
    input[type="submit"]:hover {
        background: #ffd7a5;
        transform: translateY(-3px);
        box-shadow: 0 9px 0 #e5ad70;
    }
    input[type="submit"]:active {
        transform: translateY(2px);
        box-shadow: 0 3px 0 #e5ad70;
    }
    input[type="reset"] {
         background: transparent;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.55);
        box-shadow: none;
        margin-top: 4px;
    }
    input[type="reset"]:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: white;
    }
    form label:nth-of-type(2)::after {
        content: " ✦";
        color: #f9c98f;
        font-size: 12px;
    }
    @media (max-width: 600px) {
        body {
            padding: 20px 15px;
        }
        form {
            padding: 30px 24px;
            border-radius: 24px;
        }
        form::before {
            font-size: 32px;
        }
        input[type="text"],
        textarea {
            padding: 14px;
        }
    }


    @media (max-width: 380px) {
        form {
            padding: 25px 18px;
        }
        form::before {
            font-size: 28px;
        }
    }

    </style>
</head>
<body>
    <form action="coment.php" method="POST">
        <label for="asu">ASUNTO</label>
        <input type="text" name="asu" placeholder="Escribe el asunto...">
        <label for="come">COMENTARIO</label>
        <textarea name="come" placeholder="Escribe tu comentario..."></textarea>
        <input type="submit" value="ENVIAR">
        <input type="reset" value="BORRAR">
    </form>
</body>
</html>

