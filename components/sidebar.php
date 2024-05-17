<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php	");
    exit();
}
?>
<aside
    class=" bg-white w-60 h-screen fixed   flex flex-col justify-between transition-transform -translate-x-full  shadow border-gray-200 sm:translate-x-0"
    id="sidebar">



    <ul class="flex flex-col mt-6 px-2   ">
        <div class="flex items-center">

            <span class="material-symbols-outlined text-pallete-400 flex mr-2 ml-[.7rem] text-3xl   ">
                apartment
            </span>
            <a href="index.php" class=" py-2 text-lg font-semibold">Apartment Mgt</a>

        </div>
        <div>
            <li
                class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-6   <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active"' : 'text-gray-500 hover:bg-pallete-100'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"
                    class="text-white mr-2">
                    <path
                        d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"
                        fill="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'white"' : 'gray'; ?>" />

                </svg>
                <a href="index.php" class="w-full">Dashboard</a>
            </li>

            <li
                class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-2  <?= basename($_SERVER['PHP_SELF']) == 'tenants.php' ? 'active"' : 'text-gray-500 hover:bg-pallete-100'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" class="mr-2">
                    <path
                        d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"
                        fill="<?= basename($_SERVER['PHP_SELF']) == 'tenants.php' ? 'white"' : 'gray'; ?>" />
                    />
                </svg>
                <a href="tenants.php" class="w-full">Tenants</a>
            </li>

            <li
                class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-2  <?= basename($_SERVER['PHP_SELF']) == 'rooms.php' ? 'active"' : 'text-gray-500 hover:bg-pallete-100'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" class="mr-2">
                    <path
                        d="M120-120v-80h80v-640h400v40h160v240h-80v-160h-80v240h-80v-280H280v560h200v80H120Zm560 40-12-60q-12-5-22.5-11T625-165l-58 20-40-69 45-40q-2-15-2-25.5t2-25.5l-45-40 40-69 58 20q10-8 20.5-14.5T668-420l12-60h80l12 60q12 5 22.5 11t20.5 14l58-20 40 69-45 40q2 15 2 25.5t-2 25.5l45 40-40 69-58-19q-10 8-20.5 14T772-140l-12 60h-80Zm40-120q33 0 56.5-23.5T800-280q0-33-23.5-56.5T720-360q-33 0-56.5 23.5T640-280q0 33 23.5 56.5T720-200ZM440-440q-17 0-28.5-11.5T400-480q0-17 11.5-28.5T440-520q17 0 28.5 11.5T480-480q0 17-11.5 28.5T440-440ZM280-200v-560 560Z"
                        fill="<?= basename($_SERVER['PHP_SELF']) == 'rooms.php' ? 'white"' : 'gray'; ?>" />

                </svg>
                <a href="rooms.php" class="w-full">Rooms</a>
            </li>

            <li
                class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-2  <?= basename($_SERVER['PHP_SELF']) == 'invoices.php' ? 'active"' : 'text-gray-500 hover:bg-pallete-100'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" class="mr-2">
                    <path
                        d="M240-80q-50 0-85-35t-35-85v-120h120v-560l60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60v680q0 50-35 85t-85 35H240Zm480-80q17 0 28.5-11.5T760-200v-560H320v440h360v120q0 17 11.5 28.5T720-160ZM360-600v-80h240v80H360Zm0 120v-80h240v80H360Zm320-120q-17 0-28.5-11.5T640-640q0-17 11.5-28.5T680-680q17 0 28.5 11.5T720-640q0 17-11.5 28.5T680-600Zm0 120q-17 0-28.5-11.5T640-520q0-17 11.5-28.5T680-560q17 0 28.5 11.5T720-520q0 17-11.5 28.5T680-480ZM240-160h360v-80H200v40q0 17 11.5 28.5T240-160Zm-40 0v-80 80Z"
                        fill="<?= basename($_SERVER['PHP_SELF']) == 'invoices.php' ? 'white"' : 'gray'; ?>" />
                </svg>
                <a href="invoices.php" class="w-full">Invoices</a>
            </li>

            <li
                class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-2  <?= basename($_SERVER['PHP_SELF']) == 'payments.php' ? 'active"' : 'text-gray-500 hover:bg-pallete-100'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" class="mr-2">
                    <path
                        d="M560-440q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM280-320q-33 0-56.5-23.5T200-400v-320q0-33 23.5-56.5T280-800h560q33 0 56.5 23.5T920-720v320q0 33-23.5 56.5T840-320H280Zm80-80h400q0-33 23.5-56.5T840-480v-160q-33 0-56.5-23.5T760-720H360q0 33-23.5 56.5T280-640v160q33 0 56.5 23.5T360-400Zm440 240H120q-33 0-56.5-23.5T40-240v-440h80v440h680v80ZM280-400v-320 320Z"
                        fill="<?= basename($_SERVER['PHP_SELF']) == 'payments.php' ? 'white"' : 'gray'; ?>" />
                </svg>
                <a href="payments.php" class="w-full">Payments</a>
            </li>



            <li
                class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-2  <?= basename($_SERVER['PHP_SELF']) == 'visitor.php' ? 'active"' : 'text-gray-500 hover:bg-pallete-100'; ?>">
                <svg class="w-6 h-6 mr-2 <?= basename($_SERVER['PHP_SELF']) == 'visitor.php' ? 'text-white' : 'text-gray-800 dark:text-white'; ?>"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                </svg>

                <a href="visitor.php" class="w-full">Visitor Log</a>
            </li>


            <li
                class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-2  <?= basename($_SERVER['PHP_SELF']) == 'maintenance.php' ? 'active"' : 'text-gray-500 hover:bg-pallete-100'; ?>">
                <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 14v7M5 4.971v9.541c5.6-5.538 8.4 2.64 14-.086v-9.54C13.4 7.61 10.6-.568 5 4.97Z" />
                </svg>

                <a href="maintenance.php" class="w-full">Maintenance</a>
            </li>

            <li
                class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-2  <?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active"' : 'text-gray-500 hover:bg-pallete-100'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" class="mr-2">
                    <path
                        d="M680-280q25 0 42.5-17.5T740-340q0-25-17.5-42.5T680-400q-25 0-42.5 17.5T620-340q0 25 17.5 42.5T680-280Zm0 120q31 0 57-14.5t42-38.5q-22-13-47-20t-52-7q-27 0-52 7t-47 20q16 24 42 38.5t57 14.5ZM480-80q-139-35-229.5-159.5T160-516v-244l320-120 320 120v227q-19-8-39-14.5t-41-9.5v-147l-240-90-240 90v188q0 47 12.5 94t35 89.5Q310-290 342-254t71 60q11 32 29 61t41 52q-1 0-1.5.5t-1.5.5Zm200 0q-83 0-141.5-58.5T480-280q0-83 58.5-141.5T680-480q83 0 141.5 58.5T880-280q0 83-58.5 141.5T680-80ZM480-494Z"
                        fill="<?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'white"' : 'gray'; ?>" />
                </svg>
                <a href="admin.php" class="w-full">Admin</a>
            </li>


            
            <li
                class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-2  <?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active"' : 'text-gray-500 hover:bg-pallete-100'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" class="mr-2">
                    <path
                        d="M680-280q25 0 42.5-17.5T740-340q0-25-17.5-42.5T680-400q-25 0-42.5 17.5T620-340q0 25 17.5 42.5T680-280Zm0 120q31 0 57-14.5t42-38.5q-22-13-47-20t-52-7q-27 0-52 7t-47 20q16 24 42 38.5t57 14.5ZM480-80q-139-35-229.5-159.5T160-516v-244l320-120 320 120v227q-19-8-39-14.5t-41-9.5v-147l-240-90-240 90v188q0 47 12.5 94t35 89.5Q310-290 342-254t71 60q11 32 29 61t41 52q-1 0-1.5.5t-1.5.5Zm200 0q-83 0-141.5-58.5T480-280q0-83 58.5-141.5T680-480q83 0 141.5 58.5T880-280q0 83-58.5 141.5T680-80ZM480-494Z"
                        fill="<?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'white"' : 'gray'; ?>" />
                </svg>
                <a href="maintenance.php" class="w-full">Maintenance</a>
            </li>


        </div>



    </ul>


    <ul class="mb-2">


        <li class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-2 ">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" class="mr-2">
                <path
                    d="M440-440v-400h80v400h-80Zm40 320q-74 0-139.5-28.5T226-226q-49-49-77.5-114.5T120-480q0-80 33-151t93-123l56 56q-48 40-75 97t-27 121q0 116 82 198t198 82q117 0 198.5-82T760-480q0-64-26.5-121T658-698l56-56q60 52 93 123t33 151q0 74-28.5 139.5t-77 114.5q-48.5 49-114 77.5T480-120Z"
                    fill="#ff3030" />
            </svg>
            <a href="../logout.php" class="w-full text-gray-500 text-lg">Logout</a>
        </li>
        </div>
    </ul>


</aside>