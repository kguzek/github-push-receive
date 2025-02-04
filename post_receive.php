<?php
try {
  $payload = json_decode($_REQUEST['payload']);
} catch (Exception $e) { ?>
  <p>Invalid payload</p>
<?php exit(0);
}

//log the request
file_put_contents('github-webhook.log', print_r($payload, TRUE), FILE_APPEND);


if ($payload->ref !== 'refs/heads/main') { ?>
  <p>Skipping deployment for branch "<?php echo $payload->ref; ?>"</p>
<?php exit(0);
}
$repo_name = $payload->repository->name;
if (!preg_match("/^[\w-]+$/", $repo_name)) { ?>
  <p>Invalid repository name "<?php echo $repo_name; ?>"</p>
<?php exit(0);
}
?>
<p>Deploying "<?php echo "{$repo_name}"; ?>" branch main</p>
<?php

$result_code = 1;
exec("deployer.sh {$repo_name}", $null, $result_code);
if ($result_code !== 0) { ?>
  <p>Deployment failed with code <?php echo $result_code; ?></p>
<?php exit(0);
}
?>
<p>Deployment successful</p>