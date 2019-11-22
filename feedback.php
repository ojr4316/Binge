<?php
include("pageSetup.php");
?>

<div class="container">
<form class="mt-5" id="watchRequest" method="post" action="addFeedback.php">
  <h3> We'd love to hear from you! </h3>
  <div class="form-group">
    <textarea required class="form-control" id="feedbackInput" name="feedback" rows="5" style="resize: none;"></textarea>
  </div>
  <button type="submit" class="btn btn-primary binge-red-bg ">Submit</button>
</form>
</div>
</body>

</html>
