<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "risk_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add a new risk
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_risk'])) {
    $scenario = $_POST['scenario'];
    $source = $_POST['source'];
    $threats = $_POST['threats'];
    $vulnerabilities = $_POST['vulnerabilities'];
    $type = $_POST['type'];
    $function = $_POST['function'];
    $site = $_POST['site'];
    $initiative = $_POST['initiative'];
    $initiative_level = $_POST['initiative_level'];
    $status = $_POST['status'];
    $status_date = $_POST['status_date'];
    $reported_by = $_POST['reported_by'];
    $reporting_date = $_POST['reporting_date'];

    $sql = "INSERT INTO risks (scenario, source, threats, vulnerabilities, type, function, site, initiative, initiative_level, status, status_date, reported_by, reporting_date)
            VALUES ('$scenario', '$source', '$threats', '$vulnerabilities', '$type', '$function', '$site', '$initiative', '$initiative_level', '$status', '$status_date', '$reported_by', '$reporting_date')";

    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete a risk
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM risks WHERE id=$id";
    $conn->query($sql);
}

// Fetch risks to display
$sql = "SELECT * FROM risks";
$result = $conn->query($sql);

// التحقق من اللغة المختارة في الرابط أو الجلسة
if (isset($_GET['lang'])) {
    $language = $_GET['lang'];
    $_SESSION['lang'] = $language;
  }elseif (isset($_SESSION['lang'])) {
    $language = $_SESSION['lang'];
  }else {
    $language = 'english'; // اللغة الافتراضية
  }

// تحميل ملف اللغة المناسب
// $lang = include("lang/{$english}.php");
$lang = include("{$language}.php");
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <link rel="stylesheet" href="tasks.css">
    <style>
        body {
            direction: <?php echo $language == 'ar' ? 'rtl' : 'ltr'; ?>;
            text-align: <?php echo $language == 'ar' ? 'right' : 'left'; ?>;
        }
    </style>
</head>
<body>
    <header>
        <img src="logo.jpeg" alt="Logo" class="logo">
        <nav class="header-tabs">
            <ul>
                <li><a href="#"> Tasks </a> </li> 
                <li><a href="#"> <?php echo $lang['Reports']; ?> </a> </li>
            </ul>
            <div class="dropdown">
                <img src="bar.png" alt="Logo" class="bar">
                <div class="dropdown-content">
                    <ul class="dropdown-content-li">
                        <li><a href="#"> <?php echo $lang['Performance']; ?> </a></li>
                        <li><a href="#"> <?php echo $lang['Compliance']; ?> </a></li>
                        <li><a href="#"> <?php echo $lang['Assets']; ?> </a></li>
                        <li><a href="#"> <?php echo $lang['Crisis']; ?> </a></li>
                        <li><a href="#"> <?php echo $lang['Risk']; ?> </a></li>
                        <li><a href="#"> <?php echo $lang['BCM']; ?> </a></li>
                    </ul>
                </div>
            </div>
            <img src="notification.svg" alt="Logo" class="not">
        </nav>
        <div class="dropdown-user">
            <img src="user.svg" alt="Logo" class="arrow">
            <div class="dropdown-content-user">
                <ul class="dropdown-content-li">
                    <li> <a href="#"> <?php echo $lang['Notification']; ?> </a></li>
                    <li> <a href="#"> <?php echo $lang['Setting']; ?>  </a></li>
                    <li> <a href="#"> <?php echo $lang['SignOut']; ?> </a></li>
                    <li class="lang"> <a href="#"> <?php echo $lang['language']; ?> </a>
                        <ul class="lang-sett">
                            <li> <a href="?lang=english">English</a> </li>
                            <li> <a href="?lang=arabic">العربية</a> </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container">

        <div class="main-content3">
            <div class="serachcon">
                <div class="search-bar">
                    <form method="GET" action="">
                        <img src="search.svg" alt="Logo" class="serach">
                        <input type="text" name="search_id" placeholder="Search" />
                        <img src="sliders.svg" alt="Logo" class="slider">
                    </form>
                </div>
            </div><br>
            <div class="container filter">
                <div class="filters">
                    <input type="checkbox" name="selectAll"/>
                    <label>All</label>
                </div>
                <div class="filters">
                    <input type="checkbox" name="selectWork"/>
                    <label>Work</label>
                </div>
                <div class="filters">
                    <input type="checkbox" name="selectPerson"/>
                    <label>Person</label>
                </div>
            </div>
        </div>

        <div class="task-filters">
            <ul id="myUL">
                <li><span class="caret">Status</span>
                    <ul class="nested">
                        <li>New</li>
                        <li>In-Progress</li>
                        <li>Pending</li>
                        <li>Completed</li>
                        <li>Archived</li>
                    </ul>
                </li>


                <li><span class="caret">New</span>
                    <ul class="nested">
                        <li>Task1</li>
                        <li>Task2</li>
                        <li><span class="caret">Task3</span>
                            <ul class="nested">
                                <li>SubTask1</li>
                                <li>SubTask1</li>
                            </ul>
                        </li>  
                    </ul>
                </li>

                <li><span class="caret">In-Progress</span>
                    <ul class="nested">
                        <li>Task1</li>
                        <li>Task2</li>
                        <li><span class="caret">Task3</span>
                            <ul class="nested">
                                <li>SubTask1</li>
                                <li>SubTask1</li>
                            </ul>
                        </li>  
                    </ul>
                </li>

                <li><span class="caret">Pending</span>
                    <ul class="nested">
                        <li>Task1</li>
                        <li>Task2</li>
                        <li><span class="caret">Task3</span>
                            <ul class="nested">
                                <li>SubTask1</li>
                                <li>SubTask1</li>
                            </ul>
                        </li>  
                    </ul>
                </li>

                <li><span class="caret">Completed</span>
                    <ul class="nested">
                        <li>Task1</li>
                        <li>Task2</li>
                        <li><span class="caret">Task3</span>
                            <ul class="nested">
                                <li>SubTask1</li>
                                <li>SubTask1</li>
                            </ul>
                        </li>  
                    </ul>
                </li>


                <li><span class="caret">Archived</span>
                    <ul class="nested">
                        <li>Task1</li>
                        <li>Task2</li>
                        <li><span class="caret">Task3</span>
                            <ul class="nested">
                                <li>SubTask1</li>
                                <li>SubTask1</li>
                            </ul>
                        </li>  
                    </ul>
                </li>
            </ul>

            <script>
                var toggler = document.getElementsByClassName("caret");
                var i;

                for (i = 0; i < toggler.length; i++) {
                toggler[i].addEventListener("click", function() {
                    this.parentElement.querySelector(".nested").classList.toggle("active");
                    this.classList.toggle("caret-down");
                });
                }
            </script>
        </div>

        <!-- main container 2 -->
        <?php 
            $search_id = isset($_GET['search_id']) ? $_GET['search_id'] : '';
            $sql = "SELECT id,scenario,status FROM risks";

            if ($search_id) {
                $sql .= " WHERE id = $search_id";
                }
            $result = $conn->query($sql);
            ?>
        <script>
            function updateDiv(id, scenario) {
                var dynamicDiv_id = document.getElementById("dynamicDiv_id");
                var dynamicDiv_scenario = document.getElementById("dynamicDiv_senario");

                dynamicDiv_id.innerHTML = id;
                dynamicDiv_scenario.innerHTML = scenario;
            }
        </script>
          
        <div class="main-content2">
            <div class="table-header">
                <nav class="header-content "></nav>
                <nav class="header-content header-id">ID</nav>
                <nav class="header-content header-name">Task</nav>
                <nav class="header-content header-status">Status</nav>
                <nav class="header-content header-date">Due Date</nav>
                <nav class="header-content header-type">Type</nav>
            </div>
            <div class="table"> 
                <table>
                    <tbody>
                        <tr>
                            <td class="select-task"><input type="checkbox" name="selectPerson"/></td>
                            <td onclick='openModal()' class="id-task">1</td>
                            <td onclick='openModal()' class="task-identify">
                                Create To Do List
                                <div class="table-icon">
                                    <img src="new.svg" alt="New">
                                    <img src="archive.svg" alt="archive">
                                    <img src="false.svg" alt="Delete">
                                </div>
                            </td>
                            <td onclick='openModal()' class="statue-task">New</td>
                            <td onclick='openModal()' class="date-task">2023/9/14</td>
                            <td onclick='openModal()' class="type-task">Person</td>
                        </tr>
                        <tr>
                            <td class="select-task"><input type="checkbox" name="selectPerson"/></td>
                            <td onclick='openModal()' class="id-task">2</td>
                            <td onclick='openModal()' class="task-identify">
                                Create To Do List
                                <div class="table-icon">
                                    <img src="new.svg" alt="New">
                                    <img src="archive.svg" alt="archive">
                                    <img src="false.svg" alt="Delete">
                                </div>
                            </td>
                            <td onclick='openModal()' class="statue-task">In-Progress</td>
                            <td onclick='openModal()' class="date-task">2023/9/14</td>
                            <td onclick='openModal()' class="type-task">Person</td>
                        </tr>
                        <tr>
                            <td class="select-task"><input type="checkbox" name="selectPerson"/></td>
                            <td onclick='openModal()' class="id-task">3</td>
                            <td onclick='openModal()' class="task-identify">
                                Create To Do List
                                <div class="table-icon">
                                    <img src="new.svg" alt="New">
                                    <img src="archive.svg" alt="archive">
                                    <img src="false.svg" alt="Delete">
                                </div>
                            </td>
                            <td onclick='openModal()' class="statue-task">Pending</td>
                            <td onclick='openModal()' class="date-task">2023/9/14</td>
                            <td onclick='openModal()' class="type-task">Person</td>
                        </tr>
                        <tr>
                            <td class="select-task"><input type="checkbox" name="selectPerson"/></td>
                            <td onclick='openModal()' class="id-task">4</td>
                            <td onclick='openModal()' class="task-identify">
                                Create To Do List
                                <div class="table-icon">
                                    <img src="new.svg" alt="New">
                                    <img src="archive.svg" alt="archive">
                                    <img src="false.svg" alt="Delete">
                                </div>
                            </td>
                            <td onclick='openModal()' class="statue-task">Completed</td>
                            <td onclick='openModal()' class="date-task">2023/9/14</td>
                            <td onclick='openModal()' class="type-task">Person</td>
                        </tr>
                        <tr>
                            <td class="select-task"><input type="checkbox" name="selectPerson"/></td>
                            <td onclick='openModal()' class="id-task">5</td>
                            <td onclick='openModal()' class="task-identify">
                                Create To Do List
                                <div class="table-icon">
                                    <img src="new.svg" alt="New">
                                    <img src="archive.svg" alt="archive">
                                    <img src="false.svg" alt="Delete">
                                </div>
                            </td>
                            <td onclick='openModal()' class="statue-task">New</td>
                            <td onclick='openModal()' class="date-task">2023/9/14</td>
                            <td onclick='openModal()' class="type-task">Person</td>
                        </tr>
                        <tr>
                            <td class="select-task"><input type="checkbox" name="selectPerson"/></td>
                            <td onclick='openModal()' class="id-task">6</td>
                            <td onclick='openModal()' class="task-identify">
                                Create To Do List
                                <div class="table-icon">
                                    <img src="new.svg" alt="New">
                                    <img src="archive.svg" alt="archive">
                                    <img src="false.svg" alt="Delete">
                                </div>
                            </td>
                            <td onclick='openModal()' class="statue-task">Completed</td>
                            <td onclick='openModal()' class="date-task">2023/9/14</td>
                            <td onclick='openModal()' class="type-task">Person</td>
                        </tr>
                        <tr>
                            <td class="select-task"><input type="checkbox" name="selectPerson"/></td>
                            <td onclick='openModal()' class="id-task">7</td>
                            <td onclick='openModal()' class="task-identify">
                                Create To Do List
                                <div class="table-icon">
                                    <img src="new.svg" alt="New">
                                    <img src="archive.svg" alt="archive">
                                    <img src="false.svg" alt="Delete">
                                </div>
                            </td>
                            <td onclick='openModal()' class="statue-task">Pending</td>
                            <td onclick='openModal()' class="date-task">2023/9/14</td>
                            <td onclick='openModal()' class="type-task">Person</td>
                        </tr>
                        <tr>
                            <td class="select-task"><input type="checkbox" name="selectPerson"/></td>
                            <td onclick='openModal()' class="id-task">8</td>
                            <td onclick='openModal()' class="task-identify">
                                Create To Do List
                                <div class="table-icon">
                                    <img src="new.svg" alt="New">
                                    <img src="archive.svg" alt="archive">
                                    <img src="false.svg" alt="Delete">
                                </div>
                            </td>
                            <td onclick='openModal()' class="statue-task">New</td>
                            <td onclick='openModal()' class="date-task">2001/1/9</td>
                            <td onclick='openModal()' class="type-task">Person</td>
                        </tr>
                        <tr>
                            <td class="select-task"><input type="checkbox" name="selectPerson"/></td>
                            <td onclick='openModal()' class="id-task">9</td>
                            <td onclick='openModal()' class="task-identify">
                                Create To Do List
                                <div class="table-icon">
                                    <img src="new.svg" alt="New">
                                    <img src="archive.svg" alt="archive">
                                    <img src="false.svg" alt="Delete">
                                </div>
                            </td>
                            <td onclick='openModal()' class="statue-task">New</td>
                            <td onclick='openModal()' class="date-task">2023/10/30</td>
                            <td onclick='openModal()' class="type-task">Person</td>
                        </tr>
                        <tr>
                            <td class="select-task"><input type="checkbox" name="selectPerson"/></td>
                            <td onclick='openModal()' class="id-task">10</td>
                            <td onclick='openModal()' class="task-identify">
                                Create To Do List
                                <div class="table-icon">
                                    <img src="new.svg" alt="New">
                                    <img src="archive.svg" alt="archive">
                                    <img src="false.svg" alt="Delete">
                                </div>
                            </td>
                            <td onclick='openModal()' class="statue-task">New</td>
                            <td onclick='openModal()' class="date-task">2024/1/5</td>
                            <td onclick='openModal()' class="type-task">Person</td>
                        </tr>
                    </tbody>
                </table>
                <div class="modal" id="myModal">
                    <div class="modal-content">
                        <div class="modaltab">
                            <div class="modaltabR">
                                <span class="close" onclick="closeModal()">&times;</span>                                
                                <img src="minus.svg" alt="Logo" class="icon1">
                                <img src="star.svg" alt="Logo" class="icon1">
                                <img src="ellipsis.svg" alt="Logo" class="icon1">
                                <button type="button" class="icon1">Share</button>
                                <span class="icon1">created on Oct 27</span>
                            </div>

                            <div class="modaltabL">
                                <img src="arrowup.svg" alt="Logo" class="icon2">
                                <img src="arrowdown.svg" alt="Logo" class="icon2">
                                <span class="icon2 speacial">s Space /</span>
                                <span class="icon2">JAFT BMS /</span>
                                <span class="icon2">List</span>
                                <img src="exist.svg" alt="Logo" class="icon2">
                                <img src="new.svg" alt="Logo" class="icon2">
                            </div>
                        </div><hr style="height:0.5px;border-width:0;color:gray;background-color:#6f6f702e">
                        <div class="task-info">
                            <div class="task-name">
                                <h2>Create To Do List <div class="circle low-priority"></div></h2>
                            </div>
                            <div class="info">
                                <div class="task-status">
                                    <label> Status </label>
                                    <select name="task status" class="">
                                        <option value="Empty">Empty</option>
                                        <option value="New"> New </option>
                                        <option value="In-Progress"> In-Progress </option>
                                        <option value="Pending"> Pending </option>
                                        <option value="Cancelled"> Cancelled </option>
                                        <option value="Completed"> Completed </option>
                                    </select>
                                </div>

                                <div class="task-type">
                                    <label> Type </label>
                                    <select name="task type" class="">
                                        <option value="Empty">Empty</option>
                                        <option value="Personal"> Personal </option>
                                        <option value="Work"> Work </option>
                                    </select>
                                </div>
                            </div>

                            <div class="info inf2">
                                <div class="task-dates">
                                    <label>Due Dates</label>
                                    <input type="date" name="task dates" class="">
                                </div>

                                <div class="task-dates">
                                    <label>Status Dates</label>
                                    <input type="date" name="task dates" class="">
                                </div>

                                <div class="task-Assignees">
                                    <label>Assignees</label>
                                    <input type="email" name="task Assignees" class="" value="Empty">
                                </div>
                            </div>

                            <div class="task-description">
                                <textarea placeholder="Add Description"></textarea>
                            </div>


                            <div class="task-attachment">

                                <div class="tab-buttons">
                                    <div onclick="showTabContent(0)" class="active">Attachment</div>
                                    <div onclick="showTabContent(1)">Action Items</div>
                                </div>

                                <div id="content-0" class="tab-content active">
                                    <div class="upload-container" onclick="document.getElementById('file-input').click()">
                                        <p>Drop your files here to <span>upload</span></p>
                                        <input type="file" id="file-input" multiple>
                                    </div>
                                    <div class="preview" id="preview"></div>
                                    <script>
                                        const fileInput = document.getElementById('file-input');
                                        const preview = document.getElementById('preview');

                                        fileInput.addEventListener('change', () => {
                                            Array.from(fileInput.files).forEach(file => {
                                            const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    const img = document.createElement('img');
                                                    img.src = e.target.result;
                                                    preview.appendChild(img);
                                                };
                                                reader.readAsDataURL(file);
                                            });
                                        });
                                    </script>
                                </div>

                                <div id="content-1" class="tab-content">
                                    <div class="checklist-container">

                                        <!-- Checklist box -->
                                        <div class="checklist-box" id="checklist1">
                                            <div class="checklist-header">
                                                CheckList (<span class="item-count">1</span>)
                                            </div>
                                            <div class="checklist-items">
                                                <div class="checklist-item">
                                                    <input type="checkbox" class="checkbox" onclick="completeTask(this, 'checklist1')">
                                                    <input type="text" class="editable-text" value="CheckList Item" onfocus="this.select()">
                                                </div>
                                            </div>
                                            <div class="checklist-footer" onclick="addChecklistItem('checklist1')">+ New CheckList Item</div>
                                        </div>

                                        <!-- Completed section -->
                                        <div class="checklist-box" id="checklist2">
                                            <div class="checklist-header">
                                                CheckList (<span class="item-count">0</span>)
                                            </div>
                                            <div class="checklist-items"></div>
                                            <div class="checklist-footer" onclick="addChecklistItem('checklist2')">+ New CheckList Item</div>
                                        </div>
                                    </div>

                                    <script>
                                        function addChecklistItem(checklistId) {
                                            // الحصول على العنصر الذي يحتوي على العناصر الفرعية
                                            const checklistBox = document.getElementById(checklistId);
                                            const checklistItems = checklistBox.querySelector('.checklist-items');
                                            const itemCountElement = checklistBox.querySelector('.item-count');

                                            // إنشاء عنصر تحقق جديد مع مربع نص قابل للتحرير
                                            const newItem = document.createElement("div");
                                            newItem.className = "checklist-item";
                                            newItem.innerHTML = `
                                                <input type="checkbox" class="checkbox" onclick="completeTask(this, '${checklistId}')">
                                                <input type="text" class="editable-text" value="New CheckList Item" onfocus="this.select()">
                                            `;

                                            // إضافة العنصر الجديد إلى القائمة
                                            checklistItems.appendChild(newItem);

                                            // تحديث عدد العناصر في العنوان
                                            const itemCount = checklistItems.querySelectorAll('.checklist-item:not(.hidden)').length;
                                            itemCountElement.textContent = itemCount;
                                        }

                                        function completeTask(checkbox, checklistId) {
                                            const checklistBox = document.getElementById(checklistId);
                                            const checklistItems = checklistBox.querySelector('.checklist-items');
                                            const itemCountElement = checklistBox.querySelector('.item-count');

                                            // إخفاء العنصر المحدد
                                            const checklistItem = checkbox.parentElement;
                                            checklistItem.classList.add('hidden');

                                            // تحديث العدد في العنوان
                                            const itemCount = checklistItems.querySelectorAll('.checklist-item:not(.hidden)').length;
                                            itemCountElement.textContent = itemCount;
                                        }
                                    </script>
                                </div>

                                <script>
                                    function showTabContent(index) {
                                        // إخفاء كل المحتوى
                                        let contents = document.querySelectorAll('.tab-content');
                                        contents.forEach(content => content.classList.remove('active'));

                                        // إظهار المحتوى المختار
                                        document.getElementById(`content-${index}`).classList.add('active');

                                        // تغيير حالة التاب
                                        let tabs = document.querySelectorAll('.tab-buttons div');
                                        tabs.forEach(tab => tab.classList.remove('active'));
                                        tabs[index].classList.add('active');
                                    }
                                </script>

                            </div>

                        </div>
                        <div class="icon">
                                <div class="activity-info">
                                    <ul>
                                        <li><span><img src="activity.svg" alt="Logo" class="task-icon"></span></li>
                                        <li><span><img src="link.svg" alt="Logo" class="task-icon"></span></li>
                                        <li><span><img src="new.svg" alt="Logo" class="task-icon"></span></li>
                                    <ul>
                                </div>
                        </div>

                        <div class="activity">
                            <h3>Activity</h3>
                            <div class="activity-info">
                                <ul>
                                    <li>
                                        <span>Ahmed created this task</span> 
                                        <span class="date">10/11/2022</span>
                                    </li><br>
                                    <li>
                                        <span>Ahmed created this task</span> 
                                        <span class="date">10/11/2022</span>
                                    </li><br>
                                    <li>
                                        <span>Ahmed created this task</span> 
                                        <span class="date">10/11/2022</span>
                                    </li><br>
                                    <li>
                                        <span>Ahmed created this task</span> 
                                        <span class="date">10/11/2022</span>
                                    </li><br>
                                    <li>
                                        <span>Ahmed created this task</span> 
                                        <span class="date">10/11/2022</span>
                                    </li><br>
                                </ul>
                                <div class="comment">
                                    <input type="text" name="comment" placeholder="Write a Comment" class="comment-input"/>
                                    <button type="submit" class="comment-button" disabled>Send</button>
                                    <script>
                                        // تفعيل أو تعطيل زر الإرسال بناءً على محتوى حقل الإدخال
                                        const inputField = document.querySelector('.comment-input');
                                        const sendButton = document.querySelector('.comment-button');

                                        inputField.addEventListener('input', () => {
                                            sendButton.disabled = inputField.value.trim() === '';
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function openModal() {
                        document.getElementById("myModal").style.display = "flex";
                    }

                    function closeModal() {
                        document.getElementById("myModal").style.display = "none";
                    }

                    // إغلاق النافذة عند النقر خارجها
                    window.onclick = function(event) {
                        var modal = document.getElementById("myModal");
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                </script>
            </div>
            <div class="my-icon">
                <img src="todolist.jpg" alt="Logo">
                <img src="report.jpg" alt="Logo">
                <img src="document.jpg" alt="Logo">
                <img src="calender.jpg" alt="Logo">
                <img src="risk.jpg" alt="Logo">
            </div>
            <div class="submit-form">
                <button type="submit" class="new"> <img src="new.svg" alt="New"> </button>
                <button type="submit" class="save"> <img src="save.svg" alt="Save">  </button>
                <button type="submit" class="delete"> <img src="false.svg" alt="Delete"> </button>
            </div>
        </div>

    </div>

    <script src="script.js"></script>

</body>
</html>

<?php
$conn->close();
?>