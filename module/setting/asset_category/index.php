<?php 
// $id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['edit'] != 1) {
    header('location: logout.php');
}
include_once 'include/db_connection.php';
?>
    <style>

        /* .h4{
          margin-left:20px;
        } */

        /* CSS for the buttons */
        .button-container {
            display: flex;
            flex-wrap: wrap;
        }

        .button-container button {
            margin: 10px;
            padding: 10px;
            cursor: pointer;
        }

        .button-container button.selected {
            background-color: lightblue;
        }
    </style>
</head>
<body>

<div class="main">
    <div class="card shadow rounded">
        <div class="card-header" style="background: white;">
            <div class="row">
                <div class="col-6">
                    <h4>Asset Category</h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./setting" class="btn btn-primary float-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="overflow-y: scroll; overflow-x: hidden;">
            <input id="id" name="id" value="<?php echo $row['id'] ?? ''; ?>" hidden>
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                      <h4 style="margin-left: 12px;">Choose your categories</h4>
                    </div>
                </div>
            </div>
            <!-- Container for buttons -->
            <div class="button-container">
                <button id="fixed-asset" class="category-button selected">
                    <img src="include\img\fixed_asset.svg" alt="Fixed Asset Icon"> Fixed Asset
                </button>
                <button id="electronics" class="category-button selected ">
                    <img src="include\img\copy-machine.svg " alt="Electronics Icon"> Electronics
                </button>
                <button id="computer" class="category-button selected">
                    <img src="include\img\computer.svg" alt="Computer Icon"> Computer
                </button>
                <button id="vehicle" class="category-button ">
                    <img src="include\img\truck.svg" alt="Vehicle Icon"> Vehicle
                </button>
                <button id="property" class="category-button">
                    <img src="include\img\property.svg" alt="Property Icon"> Property
                </button>
                <button id="webpage" class="category-button">
                    <img src="include\img\webpage.svg" alt="Webpage Icon"> Webpage
                </button>
                <button id="proprietary" class="category-button">
                    <img src="include\img\proprietary.svg" alt="proprietary Icon"> Proprietary
                </button>
                <button id="licences" class="category-button">
                    <img src="include\img\licences.svg" alt="licences Icon"> Licences
                </button>
                <button id="disposal" class="category-button" style="display:none;">
                  <img src="include\img\property.svg" alt="Property Icon"> Disposal
              </button>
              <button id="reject" class="category-button" style="display:none;">
                  <img src="include\img\reject.svg" alt="Reject Icon"> Reject
              </button>
            </div>
            <!-- Add a Confirm button -->
            <button id="confirmButton" class="btn btn-success">Confirm</button>
        </div>
    </div>
</div>

<script>

// Function to toggle the 'selected' class on category buttons
 function toggleCategorySelection(button) {
        button.classList.toggle('selected');
    }

// Function to update tab visibility based on checkbox selection
function updateTabsVisibility() {
  const selectedCategories = Array.from(document.querySelectorAll('.category-button.selected'))
    .map(button => button.id);

  const tabs = document.querySelectorAll('.nav-tabs .nav-item');
  tabs.forEach(tab => {
    const tabId = tab.querySelector('.nav-link').id;
    if (tabId === 'tab-reject') {
      // Always show the "Reject" tab
      tab.style.display = 'block';
    } else if (selectedCategories.includes(tabId.replace('tab-', '')) || tab.querySelector('.nav-link').classList.contains('active')) {
      tab.style.display = 'block';
    } else {
      tab.style.display = 'none';
    }
  });
}

// Function to handle the Confirm button click
function handleConfirmButtonClick() {
  // Save selected categories to localStorage
  const selectedCategories = Array.from(document.querySelectorAll('.category-button.selected'))
    .map(button => button.id);
  localStorage.setItem('selectedCategories', JSON.stringify(selectedCategories));

  // Redirect to the asset page or perform any other action
  window.location.href = './asset';
}

// Add click event listeners to the category buttons
const categoryButtons = document.querySelectorAll('.category-button');
categoryButtons.forEach(button => {
  button.addEventListener('click', () => {
    toggleCategorySelection(button);
    updateTabsVisibility(); // Call the function to update tab visibility on button click
  });
});

// Add a click event listener to the Confirm button
const confirmButton = document.getElementById('confirmButton');
confirmButton.addEventListener('click', handleConfirmButtonClick);

// Function to load checkbox states from localStorage
function loadCheckboxStates() {
  const savedCategories = JSON.parse(localStorage.getItem('selectedCategories') || '[]');

  categoryButtons.forEach(button => {
    if (savedCategories.includes(button.id)) {
      toggleCategorySelection(button);
    }
  });

  // Update tab visibility based on the selected categories
  updateTabsVisibility();
}

// Function to set default selected categories
function setDefaultSelectedCategories() {
  const defaultCategories = ['fixed-asset', 'electronics', 'computer', 'disposal', 'reject'];
  defaultCategories.forEach(categoryId => {
    const button = document.getElementById(categoryId);
    if (button) {
      // Add 'selected' class to make them default selected
      toggleCategorySelection(button);
    }
  });
  // Update tab visibility based on the selected categories
  updateTabsVisibility();
}

// Call the function to load checkbox states when the page loads
window.addEventListener('load', loadCheckboxStates);

// Call the function to set default selected categories
setDefaultSelectedCategories();

</script>

