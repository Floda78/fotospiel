<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotospiel</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='50%' x='50%' dominant-baseline='middle' text-anchor='middle' font-size='50'>📸</text></svg>">
    <meta name="description" content="Ein lustiges Fotospiel mit zufälligen Aufgaben für deine Party!">
    <meta name="author" content="Dein Name">
    <style>
        body {
            background-color: #274472;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .container {
            background-color: #3C6E99;
            border-radius: 10px;
            padding: 20px 30px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 600px;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        a {
            color: #1E90FF;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .generate-button {
            background-color: #38B000;
            color: white;
            font-size: 1.1rem;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin-bottom: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .generate-button:hover {
            transform: scale(1.05);
        }

        .generate-button:active {
            transform: scale(1.05);
        }

        .upload-button {
            background-color: #aa00ff;
            color: white;
            font-size: 0.9rem;
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            cursor: pointer;
            margin-bottom: 5px;
            box-shadow: 0 3px 4px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .upload-button:hover {
            transform: scale(1.05);
        }

        .upload-button:active {
            transform: scale(1.05);
        }

        .task-display {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 20px;
            opacity: 1;
            transition: opacity 3s ease-in-out;
        }

        .fade {
            animation: fadeIn 3s forwards;
        }

        .swing {
            animation: fadeIn 3s forwards;
        }
        
        .zoom {
            animation: zoomIn 3s forwards;
        }

        .rotate {
            animation: rotateIn 3s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

         @keyframes swing {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes zoomIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        @keyframes rotateIn {
            from {
                transform: rotate(-360deg);
            }
            to {
                transform: rotate(0);
            }
        }

        .counter {
            font-size: 0.9rem;
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>

<?php

### SQL-DB Connection Herstellen

$connect = mysqli_connect(
    'sql205.infinityfree.com', # service name
    'if0_38092243', # username
    'ZEDyC42c2L', # password
    'if0_38092243_db_foto' # db table
);

### Fragen Zählen

$query = "SELECT * FROM fragen";
$response = mysqli_query($connect, $query);

if($fragen = mysqli_fetch_assoc($response)) {
    $fragencount = mysqli_num_rows($response);
}

### Zähler Abfragen

$query2 = "SELECT * FROM zaehler";
$response2 = mysqli_query($connect, $query2);

if($zaehlerdb = mysqli_fetch_assoc($response2)) {
    $zaehler = $zaehlerdb["zaehler"];
}

### Übrige Fragen zählen

$fragenleft = $fragencount - $zaehler;

?>

<body>
    <div class="container">
        <h1>Willkommen beim Fotospiel!</h1>
        <?php
        if ($fragenleft!=0 AND ($_GET["served"]=="")){
            echo "<p>Drücke bitte nur einmal auf den Button, um eine zufällige Aufgabe zu erhalten. Darauf steht eine Fotoaufgabe, z. B.:</p>
            <p><em>„Ein Gegenstand, der wie eine Zahl aussieht.“</em></p>";
        }
        if ($_GET["served"]!=""){
            echo '<p>Deine Aufgabe lautet:</p>
            <p style="color:#000000;font-size:1.3rem;background-color:lightblue;padding:12px;border-radius:10px;box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2)"><em>"'.$_GET["served"].'"</em></p>';
        }
        ?>
        <p>Du hast den ganzen Abend Zeit, dein Foto zu machen – kreativ und lustig! Lade dein Foto anschließend hier hoch:</p>
        <p><a href="https://fotospiel.onepage.me/" target="_blank"><button class="upload-button">Upload Foto</button></a></p>
        <p>Am Ende entscheidet die Jury, wer die Aufgabe am besten gelöst hat, und der Gewinner bekommt natürlich einen kleinen Preis.</p>
        <p>Hab Spaß und frag vorher, wenn du jemanden fotografieren möchtest!</p>
<?php

if (($fragenleft != 0) AND ($_GET["served"]=="")){
    echo '<a href="aufgabe.php?id='.$zaehler.'"><button class="generate-button">Aufgabe generieren</button></a>';
}

?>
        <div class="task-display" id="taskDisplay">&nbsp;</div>
        <div class="counter" id="counterDisplay">Noch <span id="tasksRemaining">
<?php

echo $fragenleft;

?>
        </span> Aufgaben übrig</div>
    </div>

</body>
</html>
