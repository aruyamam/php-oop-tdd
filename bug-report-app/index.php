<?php require_once __DIR__ . '/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Bug Report App</title>
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="resources/css/styles.css">
   <script src="resources/js/scripts.js"></script>
</head>

<body>
   <div class="container">
      <div class="table-wrapper">
         <div class="table-title">
            <div class="row">
               <div class="col-sm-6">
                  <h2>Manage <b>Bug Reports</b></h2>
               </div>
               <div class="col-sm-6">
                  <a href="#addBugReportModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i><span>Add Report</span></a>
               </div>
            </div>
         </div>
         <table class="table table-striped table-hover">
            <thead>
               <tr>
                  <th style="width: 120px;">Report Type</th>
                  <th>Email</th>
                  <th style="width: 420px;">Message</th>
                  <th>Link</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php if (isset($bugReports)) : ?>
                  <?php foreach ($bugReports as $report) : ?>
                     <tr>
                        <td><?= $report->getReportType() ?></td>
                        <td><?= $report->getEmail() ?></td>
                        <td><?= $report->getMessage() ?></td>
                        <td><?= $report->getLink() ?></td>
                        <td>
                           <a href="#updateReport-<?= $report->getId() ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                           <a href="#deleteReport-<?= $report->getId() ?>" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>

                           <!-- Edit Modal HTML -->
                           <div id="updateReport-<?= $report->getId() ?>" class="modal fade">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <form method="post">
                                       <div class="modal-header">
                                          <h4 class="modal-title">Edit Report</h4>
                                          <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       </div>
                                       <div class="modal-body">
                                          <div class="form-group">
                                             <label>Report Type</label>
                                             <select name="reportType" class="form-control" required>
                                                <option value="<?= $report->getReportType() ?>"><?= $report->getReportType() ?></option>
                                                <option value="video player">Video Player</option>
                                                <option value="audio">Audio</option>
                                                <option value="others">others</option>
                                             </select>
                                          </div>
                                          <div class="form-group">
                                             <label for="email">Email</label>
                                             <input type="email" name="email" class="form-control" value="<?= $report->getEmail() ?>" id="email" required>
                                          </div>
                                          <div class="form-group">
                                             <label for="message">Message</label>
                                             <textarea class="form-control" name="message" id="message" required><?= $report->getMessage() ?></textarea>
                                          </div>
                                          <div class="form-group">
                                             <label for="like">Link</label>
                                             <input type="link" name="link" class="form-control" id="link" value="<?= $report->getLink() ?>" required>
                                          </div>
                                       </div>
                                       <div class="modal-footer">
                                          <input type="hidden" name="reportId" value="<?= $report->getId() ?>">
                                          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                          <input type="submit" class="btn btn-success" name="update" value="Update">
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>

                           <!-- Delete Modal HTML -->
                           <div id="deleteReport-<?= $report->getId() ?>" class="modal fade">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <form method="post">
                                       <div class="modal-header">
                                          <h4 class="modal-title">Delete Report</h4>
                                          <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       </div>
                                       <div class="modal-body">
                                          <p>Are you sure you want to delete these Records?</p>
                                          <p class="text-warning"><small>This action cnnot be undone.</small></p>
                                       </div>
                                       <div class="modal-footer">
                                          <input type="hidden" name="reportId" value="<?= $report->getId() ?>">
                                          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                          <input type="submit" class="btn btn-success" name="delete" value="Delete">
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </td>
                     </tr>
                  <?php endforeach; ?>
               <?php endif; ?>
            </tbody>
         </table>
      </div>

   </div>

   <?php include_once 'addModal.php' ?>
</body>

</html>