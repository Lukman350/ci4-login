<main class="grid place-items-center min-h-screen bg-gradient-to-br from-purple-500 via-blue-500 to-green-500">
  <div class="container mx-auto">
    <div class="py-8 px-6 max-w-md mx-auto bg-white bg-opacity-30 rounded-lg shadow-lg backdrop-blur-xl backdrop-filter">
      <h1 class="text-2xl font-bold mb-4 text-gray-800">Coralis Studio - Registration</h1>

      <?php if (isset($validation)) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
          <strong class="font-bold">There were some problems with your input</strong>
          <ul>
            <?php foreach ($validation->getErrors() as $error) : ?>
              <li>&bull; <?= esc($error) ?></li>
            <?php endforeach ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="/auth/register" method="post" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
          <input type="email" id="email" name="email" class="bg-transparent border rounded-lg shadow border-gray-300 focus:border-blue-500 text-white caret-blue-500 ring-2 outline-none py-2 px-4 block w-full appearance-none leading-normal" required value="<?= isset($fields) ? $fields['email'] : '' ?>">
        </div>
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-semibold mb-2">Name:</label>
          <input type="text" id="name" name="name" class="bg-transparent border rounded-lg shadow border-gray-300 focus:border-blue-500 text-white caret-blue-500 ring-2 outline-none py-2 px-4 block w-full appearance-none leading-normal" required value="<?= isset($fields) ? $fields['name'] : '' ?>">
        </div>
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-semibold mb-2">Password:</label>
          <input type="password" id="password" name="password" class="bg-transparent border rounded-lg shadow border-gray-300 focus:border-blue-500 text-white caret-blue-500 ring-2 outline-none py-2 px-4 block w-full appearance-none leading-normal" required>
        </div>
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-semibold mb-2">Confirm Password:</label>
          <input type="password" id="confirm_password" name="confirm_password" class="bg-transparent border rounded-lg shadow border-gray-300 focus:border-blue-500 text-white caret-blue-500 ring-2 outline-none py-2 px-4 block w-full appearance-none leading-normal" required>
        </div>
        <div class="mb-4">
          <label for="profile" class="block text-gray-700 font-semibold mb-2">Profile Picture:</label>
          <input type="file" id="profile" name="profile" class="bg-transparent border rounded-lg shadow border-gray-300 focus:border-blue-500 text-white caret-blue-500 ring-2 block w-full appearance-none leading-normal file:border-none file:text-white cursor-pointer file:cursor-pointer file:py-2 file:px-4 file:bg-blue-500 file:border-r transition duration-300 ease-in-out" accept="image/jpg,image/jpeg,image/png">
        </div>
        <button type="submit" class="w-full bg-gradient-to-r from-purple-500 via-blue-500 to-green-500 text-white font-bold py-2 px-4 rounded-full border-gray-300 hover:shadow-lg transition duration-300 ease-in-out focus:ring-purple-500">Register</button>

        <p class="text-center mt-4 text-gray-700">Already have an account? <a href="/auth/login" class="text-blue-700 font-semibold hover:underline">Login</a></p>
      </form>
    </div>
  </div>
</main>