<main class="grid place-items-center min-h-screen bg-gradient-to-br from-purple-500 via-blue-500 to-green-500">
  <div class="container mx-auto">
    <div class="py-8 px-6 max-w-md mx-auto bg-white bg-opacity-30 rounded-lg shadow-lg backdrop-blur-xl backdrop-filter">
      <h1 class="text-2xl font-bold mb-4 text-gray-800">Coralis Studio - Reset Password</h1>

      <div class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert" id="error-box">
        <strong class="font-bold">There were some problems with your input</strong>
        <ul id="errors">
        </ul>
      </div>

      <form id="reset-password" method="post">
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-semibold mb-2">Password:</label>
          <input type="password" id="password" name="password" class="bg-transparent border rounded-lg shadow border-gray-300 focus:border-blue-500 text-white caret-blue-500 ring-2 outline-none py-2 px-4 block w-full appearance-none leading-normal" required>
        </div>
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-semibold mb-2">Confirm Password:</label>
          <input type="password" id="confirm_password" name="confirm_password" class="bg-transparent border rounded-lg shadow border-gray-300 focus:border-blue-500 text-white caret-blue-500 ring-2 outline-none py-2 px-4 block w-full appearance-none leading-normal" required>
        </div>
        <button type="submit" class="w-full bg-gradient-to-r from-purple-500 via-blue-500 to-green-500 text-white font-bold py-2 px-4 rounded-full border-gray-300 hover:shadow-lg transition duration-300 ease-in-out focus:ring-purple-500">Reset</button>
      </form>
    </div>
  </div>
</main>

<script>
  const form = document.getElementById('reset-password');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    const response = await fetch('/auth/reset_password', {
      method: 'POST',
      body: formData
    });

    const data = await response.json();

    if (data.success) {
      window.location.href = '/auth/login';
    } else {
      const errors = document.getElementById('errors');
      errors.innerHTML = '';

      data.message.forEach(error => {
        console.log(error);
        const li = document.createElement('li');
        li.textContent = error;
        errors.appendChild(li);
      });

      document.querySelector('#error-box').classList.remove('hidden');
    }
  });
</script>