<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
    $string = file_get_contents("people.json");
    $people = json_decode($string, true);
    $keys = array_keys($people);
    $rand_key=array_rand($keys,1);
    $mfile = fopen("messages.txt", "r");
    $messages = explode("\n", fread($mfile, filesize("messages.txt")));
    $question = '';
    $msg = 'سوال خود را بپرس';
    $en_name = $keys[$rand_key];
    $fa_name = $people[$keys[$rand_key]];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $question=$_POST["question"];
        $en_name=$_POST["person"];
        $fa_name=$people[$en_name];
        if (str_starts_with($question, "آیا")&&(str_ends_with($question,"?")||str_ends_with($question,"؟"))){
            $ansno=intval(md5($question.$en_name,False),10)%16;
            $msg=$messages[$ansno];
        }else{
            $msg="سوال درستی پرسیده نشده است.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title" style=<?php if($question=='' ||$msg=="سوال درستی پرسیده نشده است.")echo "display:none;";?>>
        <span id="label">پرسش:</span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post" action="">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                    foreach($keys as $key){
                        if ($key==$en_name)echo '<option value="'.$key.'" selected>' . $people[$key] . "</option>\n\t\t\t\t";
                        else echo '<option value="'.$key.'">' . $people[$key] . "</option>\n\t\t\t\t";
                    }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>
