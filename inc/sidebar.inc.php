
  <div id="suggestions">
    <div class="title">People you may know</div>
    <div class="wrap">
      <?php for ($i = 0; $i < 2; $i++) { ?>
      <div class="item">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr>
            <td width="50">
              <a href="#" onclick="loadpage('./profile.php?id=1', 'container .left');"><img src="uploads/04.jpg" width="39" height="39" /></a>
            </td>
            <td>
              <strong><a href="#" onclick="loadpage('./profile.php?id=1', 'container .left');">Kharol Uhagewereza</a></strong>
              <br />
              <span>Makerere University</span>
            </td>
          </tr>
        </table>
      </div>
      <?php } ?>
      <div id="spacer"></div>
    </div>
  </div>
  
  <div id="notifications">
    <div class="title">Live Notifications</div>
    <div style="margin: -5px 0 0 8px"><img src="uploads/02.jpg" /></div>
  </div>