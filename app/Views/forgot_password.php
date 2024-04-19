<main class="grid place-items-center min-h-screen bg-gradient-to-br from-purple-500 via-blue-500 to-green-500">
  <div class="container mx-auto">
    <div class="py-8 px-6 max-w-md mx-auto bg-white bg-opacity-30 rounded-lg shadow-lg backdrop-blur-xl backdrop-filter">
      <h1 class="text-2xl font-bold mb-4 text-gray-800">Coralis Studio - Forgot Password</h1>

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

      <form action="/auth/forgot_password" method="post">
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
          <input type="email" id="email" name="email" class="bg-transparent border rounded-lg shadow border-gray-300 focus:border-blue-500 text-white caret-blue-500 ring-2 outline-none py-2 px-4 block w-full appearance-none leading-normal" required value="<?= isset($fields) ? $fields['email'] : '' ?>">
        </div>
        <div class="space-y-4">
          <button type="submit" class="w-full bg-gradient-to-r from-purple-500 via-blue-500 to-green-500 text-white font-bold py-2 px-4 rounded-full hover:shadow-lg transition duration-300 ease-in-out focus:ring-purple-500">Submit</button>
          <a href="/auth/login" class="w-full block text-center bg-blue-400 text-white font-bold py-2 px-4 rounded-full border border-gray-300 hover:shadow-lg transition duration-300 ease-in-out focus:ring-purple-500">Login</a>
        </div>
      </form>
    </div>
  </div>
</main>