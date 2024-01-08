<style>
        .cssbuttons-io {
            position: relative;
            font-family: inherit;
            font-weight: 500;
            font-size: 18px;
            letter-spacing: 0.05em;
            border-radius: 0.8em;
            border: 1px solid #ccc;
            background: linear-gradient(to right, #FF8A65, #ee3923);
            color: #000;
            overflow: hidden;
            display: inline-block;
            text-decoration: none;
            cursor: pointer;
            margin-right: 10px;
            margin-bottom: 10px;
            width: 300px;
            height:80px;
        }

        .cssbuttons-io span {
            position: relative;
            z-index: 10;
            transition: color 0.4s;
            display: flex;
            align-items: center;
            padding: 0.8em 1.2em 0.8em 1.05em;
        }

        .cssbuttons-io span img {
            width: 1.6em;
            height: 1.6em;
            margin-right: 0.5em; /* Adjust spacing between icon and text */
        }

        .cssbuttons-io::before,
        .cssbuttons-io::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .cssbuttons-io::before {
            background: #f5f5f5;
            width: 120%;
            left: -10%;
            transform: skew(30deg);
            transition: transform 0.4s cubic-bezier(0.3, 1, 0.8, 1);
        }

        .cssbuttons-io:hover::before {
            transform: translate3d(100%, 0, 0);
        }

        .cssbuttons-io:active {
            transform: scale(0.95);
        }
    </style>

<main>
    <div class="ml-3">
        <h2 class="mb-5">Setting</h2>
        <div class="button-container row">
            <button class="cssbuttons-io" onclick="window.location.href='main.php?page=profile'">
                <span>
                    <img src="include\img\user_profile.svg" alt="User Profile">
                    User Profile
                </span>
            </button>

            <button class="cssbuttons-io" onclick="window.location.href='main.php?page=company'">
                <span>
                    <img src="include\img\company_profile.svg" alt="Company Profile">
                    Company Profile
                </span>
            </button>

            <button class="cssbuttons-io" onclick="window.location.href='main.php?page=password'">
                <span>
                    <img src="include\img\change_password.svg" alt="Change Password">
                    Change Password
                </span>
            </button>

            <button class="cssbuttons-io" onclick="window.location.href='main.php?page=iam'">
                <span>
                    <img src="include\img\user_management.svg" alt="User Management">
                    User Management
                </span>
            </button>

            <button class="cssbuttons-io" onclick="window.location.href='main.php?page=assetcategory'">
                <span>
                    <img src="include\img\asset_category-.svg" alt="Asset Category">
                    Asset Category
                </span>
            </button>

            <button class="cssbuttons-io" onclick="window.location.href='main.php?page=preset_asset_tag'">
                <span>
                    <img src="include\img\preset_asset_tag.svg" alt="Preset">
                    Preset Category
                </span>
            </button>

            <button class="cssbuttons-io" onclick="window.location.href='main.php?page=preset'">
                <span>
                    <img src="include\img\preset.svg" alt="Preset">
                    Preset Computer
                </span>
            </button>

            <button class="cssbuttons-io" onclick="window.location.href='main.php?page=preset_location'">
                <span>
                    <img src="include\img\location.svg" alt="Preset">
                    Preset Location
                </span>
            </button>

            <button class="cssbuttons-io" onclick="window.location.href='main.php?page=preset_inventory'">
                <span>
                    <img src="include\img\item.svg" alt="Preset Inventory">
                    Preset Inventory
                </span>
            </button>

            <button class="cssbuttons-io" onclick="window.location.href='main.php?page=backup'">
                <span>
                    <img src="include\img\backup.svg" alt="Backup">
                    Backup
                </span>
            </button>
        </div>
    </div>
</main>
