<?php echo \App\Core\View::render("Partials/header", ['title' => 'home']); ?>

<main class="flex-fill">
<div class="container py-5">
    <h2 class="mb-4 text-center">📝 Todo List</h2>

    <!-- Form Add Todo -->
    <form id="todo-form" class="d-flex mb-4" action="<?php echo htmlspecialchars(BASE_URL . '/post-todo', ENT_QUOTES, "UTF-8"); ?>" method="post">
      <input type="text" name="todo-name" id="todo-input" class="form-control me-2" placeholder="Tambah todo..." required>
      <button type="submit" class="btn btn-primary">Tambah</button>
    </form>

    Todo List
    <ul id="todo-list" class="list-group">
      <!-- Dynamic items will be inserted here -->
    </ul>

    <hr>

    <ul class="list-group">
      <?php foreach ($items as $item): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <?php echo htmlspecialchars($item['todo_name'], ENT_QUOTES, "UTF-8"); ?>
        <a href='http://localhost/simple-php-mvc-framework/delete-todo/<?php echo htmlspecialchars($item["id"], ENT_QUOTES, "UTF-8"); ?>' class="btn btn-sm btn-danger">Hapus</a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <script>
    const list = document.getElementById('todo-list');

    fetch('http://localhost/simple-php-mvc-framework/get-todo')
      .then(res => res.json())
      .then(res => {
        console.log(res[0])
        res.forEach(item => {
          const li = document.createElement('li');
          li.className = 'list-group-item d-flex justify-content-between align-items-center';
          li.innerHTML = `
            ${item['todo_name']}
            <a href='http://localhost/simple-php-mvc-framework/delete-todo/${item.id}' class="btn btn-sm btn-danger">Hapus</a>
          `;

          list.appendChild(li);
        })
      })
  </script>

</main>

<?php echo \App\Core\View::render("Partials/footer"); ?>
