<?php
if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        // module
        case 'dashboard':
            $page = 'module/dashboard/tangible/index.php';
            break;
        case 'intangible':
            $page = 'module/dashboard/intangible/intangible_index.php';
            break;
        case 'controller':
            $page = 'module/dashboard/controller/controller_index.php';
            break;

        // Approval
        case 'approval_asset':
            $page = 'module/approval/index.php';
            break;
        // Transfer Approval
        case 'approval_transfer':
            $page = 'module/approval/transfer_approval.php';
            break;
        // Dispose Approval
        case 'approval_disposal':
            $page = 'module/approval/disposal_approval.php';
            break;
        case 'approval_maintenance':
            $page = 'module/approval/maintenance_approval.php';
            break;

        // Asset
        case 'asset':
            $page = 'module/asset/index.php';
            break;
        case 'add':
            $page  = 'module/asset/add.php';
            break;
        case 'addasset':
            $page = 'module/asset/addasset.php';
            break;
        case 'viewasset':
            $page = 'module/asset/viewasset.php';
            break;
        case 'editasset':
            $page = 'module/asset/editasset.php';
            break; 

        // Electronics
        case 'viewelectronics':
            $page = 'module/electronics/viewelectronics.php';
            break;
        case 'addelectronics':
            $page = 'module/electronics/addelectronics.php';
            break;
        case 'editelectronics':
            $page = 'module/electronics/editelectronics.php';
            break;

        // Computer
        case 'viewcomputer':
            $page = 'module/computer/viewcomputer.php';
            break;
        case 'addcomputer':
            $page = 'module/computer/addcomputer.php';
            break;
        case 'editcomputer':
            $page = 'module/computer/editcomputer.php';
            break;

        // Vehicle
        case 'vehicle':
            $page = 'module/vehicle/index.php';
            break;
        case 'viewvehicle':
            $page = 'module/vehicle/viewvehicle.php';
            break;
        case 'addvehicle':
            $page = 'module/vehicle/addvehicle.php';
            break;
        case 'editvehicle':
            $page = 'module/vehicle/editvehicle.php';
            break;

        // Property
        case 'property':
            $page = 'module/property/index.php';
            break;
        // Property
        case 'addproperty':
            $page = 'module/property/add_property.php';
            break;
        
        // Residential
        case 'viewresidential':
            $page = 'module/property/residential/viewresidential.php';
            break;
        case 'addresidential':
            $page = 'module/property/residential/addresidential.php';
            break;
        case 'editresidential':
            $page = 'module/property/residential/editresidential.php';
            break;
        
        // Commercial
        case 'viewcommercial':
            $page = 'module/property/commercial/viewcommercial.php';
            break;
        case 'addcommercial':
            $page = 'module/property/commercial/addcommercial.php';
            break;
        case 'editcommercial':
            $page = 'module/property/commercial/editcommercial.php';
            break;

        // Specialized
        case 'viewspecialized':
            $page = 'module/property/specialized/viewspecialized.php';
            break;
        case 'addspecialized':
            $page = 'module/property/specialized/addspecialized.php';
            break;
        case 'editspecialized':
            $page = 'module/property/specialized/editspecialized.php';
            break;

        // Land
        case 'viewland':
            $page = 'module/property/land/viewland.php';
            break;
        case 'addland':
            $page = 'module/property/land/addland.php';
            break;
        case 'editland':
            $page = 'module/property/land/editland.php';
            break;
        
        // Intangible/Intellectual
        case 'intellectual':
            $page = 'module/intangible/index.php';
            break;

        // Add intangible
        case 'addintangible':
            $page = 'module/intangible/addintangible.php';
            break;

        case 'addwebpage':
            $page = 'module/intangible/webpage/addwebpage.php';
            break;
        case 'editwebpage':
            $page = 'module/intangible/webpage/editwebpage.php';
            break;

        case 'addproprietary':
            $page = 'module/intangible/proprietary/addproprietary.php';
            break;

        case 'addlicences':
            $page = 'module/intangible/licences/addlicences.php';
            break;

        // Inventory
        case 'inventory':
            $page = 'module/inventory/index.php';
            break;
        case 'addinventory':
            $page = 'module/inventory/addinventory.php';
            break;
        case 'viewinventory':
            $page = 'module/inventory/viewinventory.php';
            break;
        case 'editinventory':
            $page = 'module/inventory/editinventory.php';
            break;

        case 'p.o':
            $page = 'module/inventory/p.o/index.php';
            break;
        case 'addInvoice':
            $page = 'module/inventory/p.o/addInvoice.php';
            break;
            
        case 'p.i':
            $page = 'module/inventory/p.i/index.php';
            break;
        
        // Disposal
        case 'disposal':
            $page = 'module/disposal/index.php';
            break;
        case 'viewdisposal':
            $page = 'module/disposal/viewdisposal.php';
            break;
        case 'adddisposal':
            $page = 'module/disposal/adddisposal.php';
            break;
        case 'editdisposal':
            $page = 'module/disposal/editdisposal.php';
            break;


        //Customer
        case 'addcustomer':
            $page = 'module/people/customer/addcustomer.php';
            break;
        case 'customer':
            $page = 'module/people/customer/index.php';
            break;
        case 'editcustomer':
            $page = 'module/people/customer/editcustomer.php';
            break;
        case 'viewcustomer':
            $page = 'module/people/customer/viewcustomer.php';
            break;
        case 'print':
            $page = 'module/people/customer/print.php';
            break;

        // Supplier
        case 'addsupplier':
            $page = 'module/people/supplier/addsupplier.php';
            break;
        case 'supplier':
            $page = 'module/people/supplier/index.php';
            break;
        case 'editsupplier':
            $page = 'module/people/supplier/editsupplier.php';
            break;
        case 'viewsupplier':
            $page = 'module/people/supplier/viewsupplier.php';
            break;
        
        // Dealership
        case 'adddealership':
            $page = 'module/people/dealership/adddealership.php';
            break;
        case 'dealership':
            $page = 'module/people/dealership/index.php';
            break;
        case 'editdealership':
            $page = 'module/people/dealership/editdealership.php';
            break;
        case 'viewdealership':
            $page = 'module/people/dealership/viewdealership.php';
            break;

        // Staff
        case 'addstaff':
            $page = 'module/people/staff/addstaff.php';
            break;
        case 'staff':
            $page = 'module/people/staff/index.php';
            break;
        case 'editstaff':
            $page = 'module/people/staff/editstaff.php';
            break;
        case 'viewstaff':
            $page = 'module/people/staff/viewstaff.php';
            break;

        // Vendors
        case 'addvendors':
            $page = 'module/people/vendors/addvendors.php';
            break;
        case 'vendors':
            $page = 'module/people/vendors/index.php';
            break;
        case 'editvendors':
            $page = 'module/people/vendors/editvendors.php';
            break;
        case 'viewvendors':
            $page = 'module/people/vendors/viewvendors.php';
            break;
            
        // Intellectual Property
        case 'intel_property':
            $page = 'module/ip/index.php';
            break;
        case 'addintel_property':
            $page = 'module/ip/addip.php';
            break;
        
        // Under Development
        case 'monitoring':
            $page = 'module/monitoring/index.php';
            break;
        case 'scheduler':
            $page = 'module/scheduler/index.php';
            break;
        case 'devices':
            $page = "module/devices/index.php";
            break;
        case 'news':
            $page = "module/news/index.php";
            break;  

        // NFC
        case 'nfc':
            $page = "module/nfc/index.php";
            break;    
        case 'editnfc':
            $page = "module/nfc/editnfc.php";
            break; 

        // FTP
        case 'ftp':
            $page = "module/ftp/index.php";
            break;   

        // Report
        case 'status':
            $page = "module/report/status/index.php";
            break;
        case 'server':
            $page = "module/report/server/index.php";
            break;

        //Transfer
        case 'transfer':
            $page = 'module/transfer/index.php';
            break;
        case 'add_transfer':
            $page = 'module/transfer/add_transfer.php';
            break;

        case 'addtransferasset':
            $page = 'module/transfer/asset/add_transfer_asset.php';
            break;
        case 'viewtransferasset':
            $page = 'module/transfer/asset/view_transfer_asset.php';
            break;
        case 'edittransferasset':
            $page = 'module/transfer/asset/edit_transfer_asset.php';
            break;

        case 'addtransferelectronics':
            $page = 'module/transfer/electronics/add_transfer_electronics.php';
            break;
        case 'viewtransferelectronics':
            $page = 'module/transfer/electronics/view_transfer_electronics.php';
            break;
        case 'edittransferelectronics':
            $page = 'module/transfer/electronics/edit_transfer_electronics.php';
            break;

        case 'addtransfercomputer':
            $page = 'module/transfer/computer/add_transfer_computer.php';
            break;
        case 'viewtransfercomputer':
            $page = 'module/transfer/computer/view_transfer_computer.php';
            break;
        case 'edittransfercomputer':
            $page = 'module/transfer/computer/edit_transfer_computer.php';
            break;
        
        //Inspection
        case 'inspection':
            $page = 'module/inspection/index.php';
            break;

        //Maintenance
        case 'maintenance':
            $page = 'module/maintenance/index.php';
            break;
        case 'add_maintenance':
            $page = 'module/maintenance/add_maintenance.php';
            break;
        case 'view_maintenance':
            $page = 'module/maintenance/view_maintenance.php';
            break;
        case 'edit_maintenance':
            $page = 'module/maintenance/edit_maintenance.php';
            break;

        //IOT
        case 'iot':
            $page = 'module/iot/index.php';
            break;

        // Billing & Payment
        case 'billing':
            $page = "module/billing/index.php";
            break;
        case 'invoice':
            $page = "module/billing/invoice.php";
            break;
        case 'adjustment':
            $page = "module/billing/adjustment.php";
            break;
        case 'payment':
            $page = "module/billing/payment.php";
            break;
        case 'reminder':
            $page = "module/billing/reminder.php";
            break;
        
        // service
        case 'rating':
            $page = "module/service/rating.php";
            break;
        case 'service_request':
            $page = "module/service/index.php";
            break;
        case 'request_supplier':
            $page = "module/service/request_supplier.php";
            break;


        // News
        case 'news':
            $page = "module/news/index.php";
            break;
        case 'addnews':
            $page = "module/news/addnews.php";
            break;
        case 'editnews':
            $page = "module/news/editnews.php";
            break;
        case 'addupdate':
            $page = "module/news/addupdate.php";
            break;
        case 'addadvertisement':
            $page = "module/news/addadvertisement.php";
            break;
        case 'addother':
            $page = "module/news/addother.php";
            break;

        // setting
        case 'setting':
            $page = "module/setting/index.php";
            break;
        case 'profile':
            $page = "module/setting/profile/index.php";
            break;
        case 'editprofile':
            $page = "module/setting/profile/editprofile.php";
            break;

        case 'company':
            $page = "module/setting/company/index.php";
            break;
        case 'editcompany':
            $page = "module/setting/company/editcompany.php";
            break;

        // Password
        case 'password':
            $page = "module/setting/password/index.php";
            break;

        // User management
        case 'iam':  // Identity access management
            $page = "module/setting/iam/index.php";
            break;
        case 'adduser':
            $page = 'module/setting/iam/adduser.php';
            break;
        case 'edituser':
            $page = 'module/setting/iam/edituser.php';
            break;
        case 'viewuser':
            $page = 'module/setting/iam/viewuser.php';
            break;

        // Audit
        case 'audit':
            $page = "module/setting/audit/index.php";
            break;

        case 'backup':
            $page = "module/setting/backup_restore/index.php";
            break;
        case 'viewdatabase':
            $page = "module/setting/backup_restore/viewdatabase.php";
            break;

        case 'assetcategory':
            $page = "module/setting/asset_category/index.php";
            break;

        //forgot_passsword
        case 'forgot':
            $page = 'module/forgot_password/index.php';
            break;
        case 'reset':
            $page = 'module/forgot_password/reset-password.php';
            break;

        //preset   
        case 'preset':
            $page = "module/setting/preset/index.php";
            break;

        //preset_location   
         case 'preset_location':
            $page = "module/setting/preset_location/index.php";
            break;

        //preset_item   
        case 'preset_inventory':
            $page = "module/setting/preset_inventory/index.php";
            break;
        
        //preset_asset_tag   
        case 'preset_asset_tag':
        $page = "module/setting/preset_asset_tag/index.php";
        break;
        
        // Location
        case 'location':
            $page = "module/setting/preset_location/location/index.php";
            break;
        case 'addlocation':
            $page = 'module/setting/preset_location/location/addlocation.php';
            break;
        case 'editlocation':
            $page = 'module/setting/preset_location/location/editlocation.php';
            break;
        case 'viewlocation':
            $page = 'module/setting/preset_location/location/viewlocation.php';
            break; 

        // Department
        case 'department':
            $page = "module/setting/preset_location/department/index.php";
            break;
        case 'adddepartment':
            $page = "module/setting/preset_location/department/adddepartment.php";
            break;
        case 'editdepartment':
            $page = "module/setting/preset_location/department/editdepartment.php";
            break;
        case 'viewdepartment':
            $page = "module/setting/preset_location/department/viewdepartment.php";
            break;

        // Branch
        case 'addbranch':
            $page = 'module/setting/preset_location/branch/addbranch.php';
            break;
        case 'branch':
            $page = 'module/setting/preset_location/branch/index.php';
            break;
        case 'editbranch':
            $page = 'module/setting/preset_location/branch/editbranch.php';
            break;
        case 'viewbranch':
            $page = 'module/setting/preset_location/branch/viewbranch.php';
            break;
        
        // Electronic Brand
        case 'add_electronics_brand':
            $page = 'module/setting/preset/electronics_brand/add_electronics_brand.php';
            break;
        case 'editbrand':
            $page = 'module/setting/preset/electronics_brand/edit_electronics_brand.php';
            break;

        // Computer
        case 'add_computer_brand':
            $page = 'module/setting/preset/computer_brand/add_computer_brand.php';
            break;
        case 'editbrand':
            $page = 'module/setting/preset/computer_brand/editbrand.php';
            break;

        // Mobile
        case 'add_phone_brand':
            $page = 'module/setting/preset/phone_brand/add_phone_brand.php';
            break;
        case 'editbrand':
            $page = 'module/setting/preset/phone_brand/editbrand.php';
            break;

        // Virtual Machine
        case 'add_virtual_machine':
            $page = 'module/setting/preset/virtual_machine/add_virtual_machine_brand.php';
            break;
        case 'editbrand':
            $page = 'module/setting/preset/virtual_machine/editvirtual_machine.php';
            break;

        // Software Type
        case 'add_software_category':
            $page = 'module/setting/preset/software_category/add_software_category.php';
            break;
        case 'edit_software_category':
            $page = 'module/setting/preset/software_category/edit_software_category.php';
            break;

        // Remote Access
        case 'add_remote_access':
            $page = 'module/setting/preset/remote_access/add_remote_access.php';
            break;
        case 'edit_remote_access':
            $page = 'module/setting/preset/remote_access/edit_remote_access.php';
            break;
        
        // Inventory Category
        case 'add_inventory_category_item':
            $page = 'module/setting/preset_inventory/inventory_category/add_inventory_item_category.php';
            break;
        case 'edit_inventory_category_item':
            $page = 'module/setting/preset_inventory/inventory_category/edit_inventory_item_category.php';
            break;

        // Inventory Item Tag
        case 'add_inventory_item_tag':
            $page = 'module/setting/preset_inventory/inventory_item_tag/add_inventory_item_tag.php';
            break;
        case 'edit_inventory_item_tag':
            $page = 'module/setting/preset_inventory/inventory_item_tag/edit_inventory_item_tag.php';
            break;
        
        // Fixed Asset
        case 'addfixedasset':
            $page = 'module/setting/preset_asset_tag/fixed_asset/addfixedasset.php';
            break;
        case 'editfixedasset':
            $page = 'module/setting/preset_asset_tag/fixed_asset/editfixedasset.php';
            break;

        // Electronics
        case 'addelectronicsassettag':
            $page = 'module/setting/preset_asset_tag/electronics/addelectronics.php';
            break;
        case 'editelectronics':
            $page = 'module/setting/preset_asset_tag/electronics/editelectronics.php';
            break;

        // Computer
        case 'addcomputerassettag':
            $page = 'module/setting/preset_asset_tag/computer/addcomputer.php';
            break;
        case 'editcomputer':
            $page = 'module/setting/preset_asset_tag/computer/editcomputer.php';
            break;
        
        // Vehicle
        case 'addvehicleassettag':
            $page = 'module/setting/preset_asset_tag/vehicle/addvehicle.php';
            break;
        case 'editvehicle':
            $page = 'module/setting/preset_asset_tag/vehicle/editvehicle.php';
            break;

        // Property
        case 'addpropertyassettag':
            $page = 'module/setting/preset_asset_tag/property/addproperty.php';
            break;
        case 'editproperty':
            $page = 'module/setting/preset_asset_tag/property/editproperty.php';
            break;

        case 'signup':
            header('location: signup.php');
			exit;
        // logout
		case 'logout':
			header('location: logout.php');
			exit;
        
        // manual
        case 'manual':
            $page = "module/manual/index.php";
            break;
        case 'about_us':
            $page = "module/about_us/index.php";
            break;

        default:
            // Handle unknown page
            $page = 'module/view/404.php';
            break;
    };

    include 'module/view/main.php';
} else {
    // No page specified, include index.php
    include 'index.php';
}
?>
