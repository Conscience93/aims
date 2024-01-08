<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  /* Set a background color for the entire page */
  body {
    background-color: #f2f2f2;
    font-family: Arial, sans-serif;
  }

  /* Center the form vertically and horizontally */
  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }

  /* Style the form container */
  form {
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    padding: 5%;
    text-align: center;
    max-width: 500px;
    width: 90%; /* Adjust to your liking */
  }

  /* Style form elements */
  label {
    font-weight: bold;
    font-size: 2em; /* Adjust to your liking */
  }

  input[type="tel"] {
    width: 100%;
    padding: 3%; /* Increase the padding to make it larger */
    margin: 2% 0;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 1.6em; /* Adjust to your liking */
    height: 60px;
  }

  input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 2% 4%;
    cursor: pointer;
    font-size: 1.8em; /* Adjust to your liking */
  }

  /* Style the form submit button on hover */
  input[type="submit"]:hover {
    background-color: #45a049;
  }
</style>

<html>
<body>
<div class="container">
  <form method="post" action="generate-temporary-password.php" name="reset">
    <label><strong>Enter Your Phone Number:</strong></label><br /><br />
    <input type="phone" name="phone" placeholder="Phone Number" />
    <br /><br />
    <input type="submit" value="Reset Password" />
  </form>
</div>
</body>
</html>

