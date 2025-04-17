document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("login-form");
    const mainContent = document.getElementById("main-content");
    const userPanel = document.getElementById("user-panel");
    const adminPanel = document.getElementById("admin-panel");

    // Handle login
    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const userType = document.getElementById("user-type").value;
        
        if (username && password) {
            const usernameDisplay = document.getElementById("username-display");
            const storedUsername = localStorage.getItem("username");
            if (storedUsername) {
                usernameDisplay.textContent = storedUsername;
            }
            loginForm.classList.add("hidden");
            mainContent.classList.remove("hidden");
            localStorage.setItem("username", username);

            if (userType === "admin") {
                adminPanel.classList.remove("hidden");
            } else {
                userPanel.classList.remove("hidden");
            }
        }
    });

    // Handle logout
    document.getElementById("logout").addEventListener("click", function () {
        loginForm.classList.remove("hidden");
        mainContent.classList.add("hidden");
        adminPanel.classList.add("hidden");
        userPanel.classList.add("hidden");
        localStorage.removeItem("username");
    });
    

    // Show the correct table based on the clicked tab
    window.showTable = function (tableId, tabElement) {
        // Hide all tables
        const tables = document.querySelectorAll(".table-container");
        tables.forEach(table => table.classList.remove("active"));
        
        // Show the selected table
        const selectedTable = document.getElementById(tableId);
        selectedTable.classList.add("active");

        // Remove the active class from all tabs
        const tabs = document.querySelectorAll(".tab");
        tabs.forEach(tab => tab.classList.remove("active"));

        // Add active class to the clicked tab
        tabElement.classList.add("active");
    }
});

function toggleForm(formId) {
    const form = document.getElementById(formId);
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
    } else {
        form.classList.add('hidden');
    }
}




