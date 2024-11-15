<?php

# TODO:
# - style form
# - make input fields mandatory (html validation is fine, no need js)
# - improve style
# - add information text so users know what is this and how to use it
# - check for errors when writing to the json file
# - repopulate the form with the data and display error if could not save data

$jsonFile = '../data/projects.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project = [
        'title' => $_POST["title"],
        'description' => $_POST["description"],
        'stack' => $_POST["stack"],
        'contact' => $_POST["contact"]
    ];

    $jsonData = file_get_contents($jsonFile);
    $projects = json_decode($jsonData, true);
    $projects[] = $project;
    $jsonData = json_encode($projects, JSON_PRETTY_PRINT);
    file_put_contents($jsonFile, $jsonData);
    header('Location: /');
    exit;
}

// Add a project if the data file does not exist for testing
if (!file_exists($jsonFile)) {
    $project = [[
        'title' => 'Project name',
        'description' => 'Project description',
        'stack' => 'Tech stack',
        'contact' => 'Contact name',
    ]];
    
    echo "file does not exist, creating...";
    $jsonData = json_encode($project, JSON_PRETTY_PRINT);
    file_put_contents($jsonFile, $jsonData);
}

$jsonData = file_get_contents($jsonFile);
$projects = json_decode($jsonData, true);

if (!is_array($projects)) {
    echo "No projects";
    exit;
}
?>

<html>
    <meta charset="UTF-8">
    <title>WeDev Network Projects</title>
    <meta name="description" content="WebDev network community projects">
    <link rel="stylesheet" href="style.css?v=0.2">
    <body>
        <div class="content">
            <h1>WeDev Network Projects</h1>
            <?php foreach($projects as $project) { ?>
                <div class="project">
                    <div class="project-title">
                        <div class="content"><?php echo $project['title']; ?></div>
                    </div>
                    <div class="content">
                        <div><?php echo nl2br($project['description']); ?></div>
                        <div><?php echo nl2br($project['stack']); ?></div>
                        <div><?php echo $project['contact']; ?></div>
                    </div>
                </div>
            <?php } ?>

            <h2>Add your project</h2>
            <form method="post">
                <label>Title</label>
                <input type="text" name="title">
                <label>Description</label>
                <textarea name="description"></textarea>
                <label>Tech stack</label>
                <textarea name="stack"></textarea>
                <label>Contact</label>
                <input type="tezxt" name="contact"></input>
                <input type="submit" value="add"></input>
            </form>
        </div>
    </body>
</html>
