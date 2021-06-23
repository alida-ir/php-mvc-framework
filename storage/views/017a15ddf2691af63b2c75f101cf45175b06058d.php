<p>500 Not Found !</p>

<?php if(!empty($message['exist'])): ?>
    <p>Class : <?php echo e(@ $message['Class']); ?></p>
    <p>Message : <?php echo e(@ $message['Message']); ?></p>
    <p>GetTraceAsString : <?php echo e(@ $message['GetTraceAsString']); ?></p>
    <p>File : <?php echo e(@ $message['File']); ?></p>
    <p>Line : <?php echo e(@ $message['Line']); ?></p>
    <p>Code : <?php echo e(@ $message['Code']); ?></p>
<?php endif; ?>

<?php if(is_string($message)): ?>

    <p>Message : <?php echo e(@ $message); ?></p>

<?php endif; ?><?php /**PATH /opt/lampp/htdocs/alida_ir/resources/views/errors/500.blade.php ENDPATH**/ ?>