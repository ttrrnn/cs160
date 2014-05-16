<?php require('db_connect.php');

$course_data = array(
  "name" => "Educademy",
  "children" => array()
);

$stmt = $db->prepare("SELECT DISTINCT site FROM course_data ORDER BY site");
$stmt->execute();
$stmt->bind_result($site);
                        
while ($stmt->fetch()) {
  $course_data["children"][] = array (
    "name" => $site,
    "children" => array()
  );
}

foreach ($course_data['children'] as $index => &$mooc) {
  $stmt = $db->prepare("SELECT DISTINCT category FROM course_data WHERE site = ? ORDER BY category");
  $stmt->bind_param('s', $mooc["name"]);
  $stmt->execute();
  $stmt->bind_result($category);

  $single_categories = array();

  while ($stmt->fetch()) {
    $category = strtok($category, " \n\t&/");

    if ($category != "") {
      $single_categories[] = $category;
    }
  }

  foreach (array_unique($single_categories) as $category) {
    $mooc["children"][] = array (
      "name" => $category,
      "children" => array()
    );
  }
}

foreach ($course_data['children'] as $index => &$mooc) {
  foreach ($mooc['children'] as $index2 => &$category) {
    $stmt = $db->prepare("SELECT title FROM course_data WHERE site = ? AND category LIKE CONCAT('%', ?, '%') ORDER BY title");
    $stmt->bind_param('ss', $mooc["name"], $category["name"]);
    $stmt->execute();
    $stmt->bind_result($title);

    while ($stmt->fetch()) {
      $category["children"][] = array (
        "name" => $title
      );
    }
  }
}

$db->close();
echo json_encode($course_data);
    
?>
