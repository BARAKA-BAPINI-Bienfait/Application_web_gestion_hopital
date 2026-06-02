<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <style>
       
        button {
            border-radius: 15px;
            position: relative;
            top: 7px;
            padding: 8px;
            outline: none;
            color: black;
            background-color: aqua;
        }
        div{
            justify-content: center;
            margin: auto;
            display: flex;
            margin-top: 16%;
            gap:8px;
            
        }
        .ges{
            font-size: 25px;
            transition: .3s;
            

        }
        .ho{
            font-size: 123px;
            font-weight: bold;
            color:black;
            transition: .3s;

        }
        .ho:hover{
            text-shadow: 5px 8px 10px  white;
            transform:scale(1.2);
            cursor: pointer;
        }
        .ges:hover{
            cursor: pointer;
            text-shadow: 140px 1px 1px  white;
        }
        button{
            cursor: pointer;
            transition: .3s;
        }
        button:hover{
            transform:scale(1.2);

        }
        .rethy{
            position: relative;
            top: 8px;
            left: -100px;
            font-weight: bold;
            font-size: 25px;
            color:white;
            transition: .3s;
        }
        .rethy:hover{
            cursor: pointer;
            text-shadow: 5px 8px 10px  aqua;

        }
    </style>
    <header class="head">
        <ul>
            <h3 class="rethy">HOPITAL de Rethy</h3>
            <li><a href="">accueil</a></li>
            <li><a href="patients.php">patients</a></li>
            <li><a href="services.php">services</a></li>
            <li><a href="personnels.php">personnels</a></li>
            <li><a href="consultation.php">consultation</a></li>
            <li><a href="hospitalisation.php">hospitalisation</a></li>
            <li><a href="payement.php">payement</a></li>
            <li><a href="tableau_bord.php">tableau de bord</a></li>
            <form action="deconnexion.php" form="post">
                <button>deconnexion</button>
            </form>
        </ul>
    </header>
    <div>
        <p class="ges">Gestion de</p>
        <p class="ho">L'HOPITAL</p>
    </div>
   
</body>

</html>