<?php
function activeClass($file)
{
  return basename($_SERVER['PHP_SELF']) === $file
    ? "bg-blue-100 text-blue-600"
    : "bg-white text-gray-700";
};
?>

<aside
  class="p-2 w-64 bg-gray-100 border-r border-gray-300 min-h-[calc(100vh-185px)]">
  <nav class="">
    <ul class="space-y-2">
      <!-- Dashboard -->
      <li>
        <a
          href="./dashboard.php"
          class="flex items-center active:scale-95 px-6 py-3 hover:bg-blue-100 hover:text-blue-600 transition rounded-lg <?= activeClass('dashboard.php') ?>">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8h5a2 2 0 
           012 2v7a2 2 0 01-2 2h-5m-4 0H6a2 2 0 
           01-2-2v-7a2 2 0 012-2h5" />
          </svg>
          Dashboard
        </a>
      </li>

      <!-- Members -->
      <li>
        <a
          href="./members.php"
          class="flex items-center active:scale-95 px-6 py-3 hover:bg-blue-100 hover:text-blue-600 transition rounded-lg <?= activeClass('members.php') ?>">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 20h5v-2a4 4 0 00-3-3.87M9 20h6m-6 
           0a4 4 0 01-3-3.87V16a4 4 0 
           013-3.87M15 20a4 4 0 003-3.87V16a4 4 
           0 00-3-3.87M12 12a4 4 0 
           100-8 4 4 0 000 8z" />
          </svg>
          Members
        </a>
      </li>

      <!-- Details Chart -->
      <li>
        <a
          href="./detailsChart.php"
          class="flex items-center active:scale-95 px-6 py-3 hover:bg-blue-100 hover:text-blue-600 transition rounded-lg <?= activeClass('detailsChart.php') ?>">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 17h2M5 12h14M5 7h14M5 21h14a2 2 
           0 002-2V5a2 2 0 00-2-2H5a2 2 0 
           00-2 2v14a2 2 0 002 2z" />
          </svg>
          Details Chart
        </a>
      </li>

      <li>
        <a
          href="./../auth/logout.php"
          class="flex items-center active:scale-95 px-6 py-3 hover:bg-red-200 hover:text-red-600 transition rounded-lg bg-red-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          Logout
        </a>
      </li>

    </ul>
  </nav>
</aside>