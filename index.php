<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Application</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="header">
        <a href="#default" class="logo">CompSci 557</a>
        <div class="header-right">
            <a class="active" id="home" href="#home">Home</a>
        </div>
    </div>

    <div class="container">
        <!-- Form data can be processed by login.php -->
        <form id="login-form" action="login.php" method="POST">
            <h2>Login</h2>
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <select id="user-type" name="user_type">
                <option value="user">Linguist</option>
                <option value="admin">Project Manager</option>
            </select>
            <button type="submit">Login</button>
        </form>
        
        <div id="main-content" class="hidden">
            <p>Welcome, <span id="username-display">
                <!-- PHP can output the logged-in user's name here -->
                <?php // echo htmlspecialchars($username); ?>
            </span>!</p>

            <div id="user-panel" class="hidden">
                <h3>Linguist Panel</h3>
                <p>View your assigned projects:</p>
                <table border="1">
                    <thead>
                        <tr><th>Project</th><th>Status</th><th>Deadline</th></tr>
                    </thead>
                    <tbody id="linguist-projects">
                        <?php
                        $assignments = file_exists('assignments.json') ? json_decode(file_get_contents('assignments.json'), true) : [];

                        // need to match logged-in user ID here
                        $currentUserId = 1; // Example code:

                        $projects = [
                            1 => ['name' => 'Translate App', 'status' => 'In Progress', 'deadline' => '10/20/2025'],
                            2 => ['name' => 'Translate TV', 'status' => 'Settled', 'deadline' => '10/20/2025'],
                            3 => ['name' => 'Sports TV', 'status' => 'Not started', 'deadline' => '10/20/2025'],
                        ];

                        foreach ($assignments as $assign) {
                            if ($assign['linguist_id'] == $currentUserId) {
                                $project = $projects[$assign['project_id']];
                                echo "<tr>
                                    <td>{$project['name']}<br><small>{$assign['task_description']}</small></td>
                                    <td>{$project['status']}</td>
                                    <td>{$project['deadline']}</td>
                                </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            
            <div id="admin-panel" class="hidden">
                <h3>Project Management Panel</h3>
                <p>Manage database entries and user accounts.</p>

                <!-- Tabs -->
                <div class="tab-container">
                    <div class="tab active" onclick="showTable('project-table', this)">Projects</div>
                    <div class="tab" onclick="showTable('linguist-table', this)">Linguists</div>
                    <div class="tab" onclick="showTable('client-table', this)">Clients</div>
                </div>
                
                <!-- Tabbed Table Sections -->
                <div id="project-table" class="table-container active">
                    <!-- Create Project Toggle -->
                    <button onclick="toggleForm('project-form')">+ Create New Project</button>
                    <button onclick="toggleForm('assign-linguist-to-project')">+ Add Linguist to Project</button>


                        <!-- Hidden form for Assign Linguist to Project -->
                        <div id="assign-linguist-to-project" class="hidden">
                        <h4>Assign Linguist to Existing Project</h4>
                                                <!-- PHP DATA TO ASSIGN LINGUIST GOES HERE -->
                        <form id="assign-linguist-project-form" action="assign_linguist_to_project.php" method="POST">
                            <select name="project-id">
                                <option value="1">Translate App</option>
                                <option value="2">Translate TV</option>
                                <option value="3">Sports TV</option>
                            </select>
                            <select name="linguist-id">
                                <option value="1">Maria (Spanish)</option>
                                <option value="2">John (English)</option>
                                <option value="3">Sarah (French)</option>
                            </select>
                            <!-- Task Description Field -->
                            <textarea name="task-desc" placeholder="Task description or instructions..." rows="4" required></textarea>
                            <button type="submit">Assign Linguist</button>
                        </form>
                        </div>
                        <!-- Hidden form -->
                        <div id="project-form" class="hidden">
                        <h4>Create a New Project</h4>

                        <form id="project-creation-form" action="add_project.php" method="POST">
                            <input type="text" name="project-name" placeholder="Project Name" required>
                            <input type="date" name="start-date" required>
                            <input type="text" name="client" placeholder="Client" required>
                            <input type="number" name="word-count" placeholder="Word Count" required>
                            <select name="domain">
                                <option value="arts">Arts</option>
                                <option value="comp-sci">Computer Science</option>
                                <option value="finance">Finance</option>
                                <!-- Add more options as needed -->
                            </select>
                            <button type="submit">Create Project</button>
                        </form>
                    </div>

                    <table border="1">
                        <!-- TEMP TABLE DATA -->
                        <h4>TEMP DATA</h4>
                        <tr><th>ID</th><th>Name</th><th>Status</th><th>Deadline</th><th>Revenue</th><th>Margin</th></tr>
                        <table border="1">
                        <tr><td>1</td><td>Translate App</td><td>In Progress</td><td>10/20/2025</td><td>$5,000</td><td>20%</td></tr>
                        <tr><td>2</td><td>Translate TV</td><td>Settled</td><td>10/20/2025</td><td>$3,500</td><td>15%</td></tr>
                        <tr><td>3</td><td>Sports TV</td><td>Not started</td><td>10/20/2025</td><td>$7,000</td><td>25%</td></tr>
                        </table>
                        <?php
                        // Example PHP loop INSERT PHP TABLE DATA HERE
                        /*
                        foreach ($projects as $project) {
                            echo "<tr>
                                <td>{$project['id']}</td>
                                <td>{$project['name']}</td>
                                <td>{$project['status']}</td>
                                <td>{$project['deadline']}</td>
                                <td>{$project['revenue']}</td>
                                <td>{$project['margin']}</td>
                            </tr>";
                        }
                        */
                        ?>
                    </table>
                </div>

                    <div id="linguist-table" class="table-container">
                    <!-- Create Linguist Toggle -->
                    <button onclick="toggleForm('linguist-form')">+ Create New Linguist</button>
                    <button onclick="toggleForm('assign-linguist-to-project')">+ Add Linguist to Project</button>


                        <!-- Hidden form for Assign Linguist to Project -->
                    <div id="assign-linguist-to-project" class="hidden">
                        <h4>Assign Linguist to Existing Project</h4>
                                                <!-- PHP DATA TO ASSIGN LINGUIST GOES HERE -->
                        <form id="assign-linguist-project-form" action="assign_linguist_to_project.php" method="POST">
                            <select name="project-id">
                                <option value="1">Translate App</option>
                                <option value="2">Translate TV</option>
                                <option value="3">Sports TV</option>
                            </select>
                            <select name="linguist-id">
                                <option value="1">Maria (Spanish)</option>
                                <option value="2">John (English)</option>
                                <option value="3">Sarah (French)</option>
                            </select>
                            <!-- Task Description Field -->
                            <textarea name="task-desc" placeholder="Task description or instructions..." rows="4" required></textarea>
                            <button type="submit">Assign Linguist</button>
                        </form>
                    </div>

                    <!-- Hidden form -->
                    <div id="linguist-form" class="hidden">
                        <h4>Create a New Linguist</h4>
                        <!-- PHP DATA TO ADD LINGUIST GOES HERE -->
                        <form id="linguist-form" action="add_linguist.php" method="POST"> 
                            <input type="text" name="linguist-name" placeholder="Linguist Name" required>
                            <input type="text" name="linguist-language" placeholder="Language" required>
                            <button type="submit">Add Linguist</button>
                        </form>
                    </div>  

                    <table border="1">
                        <!-- TEMP TABLE DATA -->
                         <h4>TEMP DATA</h4>
                        <tr><th>ID</th><th>Name</th><th>Language</th><th>Available?</th></tr>
                        <tr><td>1</td><td>Maria</td><td>Spanish</td><td>Yes</td></tr>
                        <tr><td>2</td><td>John</td><td>English</td><td>No</td></tr>
                        <tr><td>3</td><td>Sarah</td><td>French</td><td>Yes</td></tr>

                        <?php
                        // Example PHP loop INSERT PHP TABLE DATA HERE
                        /*
                        foreach ($linguists as $linguist) {
                            echo "<tr>
                                <td>{$linguist['id']}</td>
                                <td>{$linguist['name']}</td>
                                <td>{$linguist['language']}</td>
                                <td>{$linguist['available']}</td>
                            </tr>";
                        }
                        */
                        ?>
                    </table>
                </div>
            
                <div id="client-table" class="table-container">
                <!-- Create Client Toggle -->
                <button onclick="toggleForm('client-form')">+ Create New Client</button>

                <!-- Hidden form -->
                <div id="client-form" class="hidden">
                    <h4>Create a New Client</h4>
                    <!-- PHP DATA TO ADD CLIENT GOES HERE -->
                    <form id="client-form" action="add_client.php" method="POST"> 
                        <input type="text" name="client-company" placeholder="Company Name" required>
                        <input type="email" name="client-contact" placeholder="Contact Email" required>
                        <button type="submit">Add Client</button>
                    </form>
                </div>

                <table border="1">
                    <!-- TEMP TABLE DATA -->
                     <h4>TEMP DATA</h4>
                    <tr><th>ID</th><th>Company</th><th>Contact</th></tr>
                    <tr><td>1</td><td>Acme Corp</td><td>acme@example.com</td></tr>
                    <tr><td>2</td><td>HBO</td><td>HBO@example.com</td></tr>
                    <tr><td>3</td><td>NBA</td><td>NBA@example.com</td></tr>

                    <?php
                    // Example PHP loop INSERT PHP TABLE DATA HERE
                    /*
                    foreach ($clients as $client) {
                        echo "<tr>
                            <td>{$client['id']}</td>
                            <td>{$client['company']}</td>
                            <td>{$client['contact']}</td>
                        </tr>";
                    }
                    */
                    ?>
                </table>
            </div>


    <footer class="footer-contact-links">
        <div class="footer-container">
            <div class="footer-section">
                <h4>Contact Us</h4>
                <p>Email: johndoe@gmail.com</p>
                <p>Phone: +1 234 567 890</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a id="logout" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Your Website. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
