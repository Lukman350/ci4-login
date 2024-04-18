<main class="min-h-screen grid place-items-center bg-gradient-to-br from-purple-500 via-blue-500 to-green-500">
  <div class="max-w-md mx-auto bg-white bg-opacity-30 rounded-lg shadow-lg backdrop-blur-xl backdrop-filter p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Coralis Studio - Home</h1>

    <p class="text-gray-700">Welcome to Coralis Studio. This is a simple authentication system built with CodeIgniter 4.</p>

    <div class="mt-4">
      <a href="/auth/logout" class="text-blue-500 font-semibold hover:underline">Logout</a>
    </div>
  </div>

  <div class="mt-4 container flex flex-col items-center max-w-4xl mx-auto">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Users</h2>

    <table class="w-full border-collapse border border-gray-300 bg-white bg-opacity-30 shadow-lg backdrop-blur-xl backdrop-filter p-6">
      <thead>
        <tr>
          <th class="border border-gray-300 px-4 py-2">ID</th>
          <th class="border border-gray-300 px-4 py-2">Name</th>
          <th class="border border-gray-300 px-4 py-2">Email</th>
          <th class="border border-gray-300 px-4 py-2">Profile</th>
          <th class="border border-gray-300 px-4 py-2">Created At</th>
          <th class="border border-gray-300 px-4 py-2">Updated At</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($users)) :
        ?>
          <?php $count = 1;
          foreach ($users as $user) : ?>
            <tr>
              <td class="border border-gray-300 px-4 py-2"><?= $count++ ?></td>
              <td class="border border-gray-300 px-4 py-2"><?= $user['name'] ?></td>
              <td class="border border-gray-300 px-4 py-2"><?= $user['email'] ?></td>
              <td class="border border-gray-300 px-4 py-2">
                <img src="/images/uploads/<?= $user['profile'] ?>" alt="<?= $user['name'] ?>" class="w-64 object-cover">
              </td>
              <td class="border border-gray-300 px-4 py-2"><?= $user['created_at'] ?></td>
              <td class="border border-gray-300 px-4 py-2"><?= $user['updated_at'] ?></td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
      </tbody>
    </table>
  </div>
</main>