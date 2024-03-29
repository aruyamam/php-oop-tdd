<!-- https://www.tutorialrepublic.com/snippets/preview.php?topic=bootstrap&file=crud-data-table-for-database-with-modal-form -->
<!-- Add Report Modal HTML -->
<div id="addBugReportModal" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="post">
            <div class="modal-header">
               <h4 class="modal-title">Submit Bug Report</h4>
               <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Report Type</label>
                  <select name="reportType" class="form-control" required>
                     <option value="video player">Video Player</option>
                     <option value="audio">Audio</option>
                     <option value="others">others</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control" id="email" required>
               </div>
               <div class="form-group">
                  <label for="message">Message</label>
                  <textarea class="form-control" name="message" id="message" required></textarea>
               </div>
               <div class="form-group">
                  <label for="like">Link</label>
                  <input type="link" name="link" class="form-control" id="link" required>
               </div>
            </div>
            <div class="modal-footer">
               <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
               <input type="submit" class="btn btn-success" name="add" value="Add">
            </div>
         </form>
      </div>
   </div>
</div>