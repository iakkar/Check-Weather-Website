<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Weather</title>
    <style>
        :root {
            background-color: rgb(54, 78, 89);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            font-family: monospace;
        }

        body {
            margin: 0 auto;
            padding: 20px;
            width: 750px;
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 30px;
            margin-top: 100px;
            color: whitesmoke;

            h1 {
                text-align: center;
            }

            form {
                margin: 0 auto;
                width: 75%;
                display: flex;
                flex-direction: column;
                gap: 15px;

                label {
                    font-size: 18px;
                    font-weight: 700;
                    padding-left: 15px;
                }

                input {
                    background-color: rgba(0, 0, 0, 0);
                    color: white;
                    padding: 5px 15px 5px 15px;
                    border: 1px solid lightskyblue;
                    border-radius: 15px;
                }

                input::placeholder {
                    color: white;
                }

                input:focus {
                    border: 1px solid lightskyblue;
                    border-radius: 15px;
                }

                button {
                    width: 25%;
                    margin: 0 auto;
                    padding: 5px;
                    background-color: rgba(0, 0, 0, 0);
                    color: white;
                    border: 1px solid lightskyblue;
                    border-radius: 15px;
                }

                button:hover {
                    cursor: pointer;
                    padding: 4px 5px 4px 5px;
                    border: 2px solid lightskyblue;
                }
            }

            #weather-info {
                width: 75%;
                min-height: 100px;
                margin: 15px auto;
                padding: 15px;
                background-color: rgba(0, 0, 0, 0.3);
                border: 1px solid lightskyblue;
                border-radius: 15px;
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <h1>Check the weather</h1>
    <form action="" method="POST">
        <label for="city">Enter the city of your choice:</label>
        <input type="text" placeholder="Ex. Athens" name="city" id="city">
        <button type="submit" id="submit">Check the weather</button>
    </form>
    <div id="weather-info">
        <?php 

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['city']) && $_POST['city'] != "") {
                    $_POST['city'] = str_replace(' ', '', $_POST['city']);
                    $headers = get_headers("https://www.weather-forecast.com/locations/" . $_POST['city'] . "/forecasts/latest");
                    if ($headers[0] != "HTTP/1.1 404 Not Found") {
                        $site = file_get_contents("https://www.weather-forecast.com/locations/" . $_POST['city'] . "/forecasts/latest");
                        $pageArray = explode('Weather Today</h2> (1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">',$site);

                        if (sizeof($pageArray) > 1) {
                            $secondPageArray = explode('</span></p></td>',$pageArray[1]);

                            if (sizeof($secondPageArray) > 1) {
                                $weather = $secondPageArray[0];
                                echo $weather;
                                echo "<script>
                                        document.getElementById(\"city\").setAttribute('placeholder','{$_POST['city']}');
                                     </script>";
                            } else {
                                echo "City was not found";
                            }

                        } else {
                            echo "City was not found";
                        }
                    } else {
                        echo "City was not found";
                    }
                }
            }
        ?>
    </div>
    <script>
        window.addEventListener ('load', () => {
            let weatherInfo = document.getElementById("weather-info").innerText.toLowerCase();
            if (weatherInfo.includes("rain")) {
                document.documentElement.style.backgroundImage = "url(assets/rain.jpg)";
            } else if (weatherInfo.includes("warm")) {
                document.documentElement.style.backgroundImage = "url(assets/warm.jpg)";
            } else {
                document.documentElement.style.backgroundImage = "url(assets/default.jpg)";
            }
        })
    </script>
</body>
</html>