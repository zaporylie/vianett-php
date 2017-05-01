
<form method="post">
    <fieldset>
      <legend>API credentials</legend>
      <div>
        <label for="sender">Username</label>
        <input type="text" required="required" name="username">
      </div>
      <div>
        <label for="recipient">Password</label>
        <input type="text" required="required" name="password">
      </div>
    </fieldset>
    <fieldset>
      <legend>Message</legend>
      <div>
          <label for="sender">Sender</label>
          <input type="text" required="required" name="sender">
      </div>
      <div>
          <label for="recipient">Recipient</label>
          <input type="text" required="required" name="recipient">
      </div>
      <div>
          <label for="message">Message</label>
          <textarea required="required" name="message"></textarea>
      </div>
    </fieldset>
    <input type="submit" value="Send">
</form>

<?php
include __DIR__ . '/../vendor/autoload.php';

try {
    if (isset(
        $_POST['username'],
        $_POST['password'],
        $_POST['sender'],
        $_POST['recipient'],
        $_POST['message']
    )) {
        // Get Vianett.
        $vianett = new \zaporylie\Vianett\Vianett(
            htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8')
        );

        // Get message resource.
        $message = $vianett->messageFactory();

        // Send message.
        $response = $message->send(
            htmlspecialchars($_POST['sender'], ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($_POST['recipient'], ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8')
        );
        print '<pre>' . var_dump($response) . '</pre>';
    }
} catch (Exception $e) {
    print '<pre>' . var_dump($e) . '</pre>';
}
