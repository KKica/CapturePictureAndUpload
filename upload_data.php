<?
    $target_dir = "uploads". DIRECTORY_SEPARATOR;

    $fileName = mktime() . ".png";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . $fileName;

    $img = $_POST['hidden_data'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    // try saving the file
    if (file_put_contents($target_file, $data)) 
        echo "The image has been uploaded." . PHP_EOL;
    else 
        echo "Sorry, there was an error uploading your file." . PHP_EOL;
    

?>