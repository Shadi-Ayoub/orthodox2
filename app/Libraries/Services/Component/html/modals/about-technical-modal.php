<?php
  $utility = service('utility');
?>

<!-- Modal -->
<div class="modal fade" id="aboutTechnicalModal" tabindex="-1" aria-labelledby="aboutTechnicalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Application & Session Technical Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="accordion" id="accordionAboutTechnical">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <h5>Application</h5>
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#aboutTechnicalModal">
              <div class="accordion-body">
                <ul>
                  <li>
                    <strong>App User Access Key ID:</strong> <span class="text-secondary"><?= $utility->stringToSecret($_ENV['APP_USER_ACCESS_KEY_ID']); ?></span>
                  </li>
                  <li>
                    <strong>App User Secret Access Key:</strong> <span class="text-secondary"><?= $utility->stringToSecret($_ENV['APP_USER_SECRET_ACCESS_KEY']); ?></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <h5>Cognito</h5>
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#aboutTechnicalModal">
              <div class="accordion-body">
                <ul>
                    <li>
                      <strong>Region:</strong> <span class="text-secondary"><?= $_ENV['COGNITO_REGION']; ?></span>
                    </li>
                    <li>
                      <strong>App Client ID:</strong> <span class="text-secondary"><?= $utility->stringToSecret($_ENV['COGNITO_APP_CLIENT_ID']); ?></span>
                    </li>
                    <li>
                      <strong>Admin User Pool ID:</strong> <span class="text-secondary"><?= $utility->stringToSecret($_ENV['COGNITO_ADMIN_USER_POOL_ID']); ?></span>
                    </li>
                    <li>
                      <strong>Admin User Pool Issuer:</strong> <span class="text-secondary"><?= $utility->stringToSecret($_ENV['COGNITO_ADMIN_USER_POOL_ISSUER']); ?></span>
                    </li>
                    <li>
                      <strong>Issuer Authenticator:</strong> <span class="text-secondary"><?= $_ENV['COGNITO_ISSUER_AUTHENTICATOR']; ?></span>
                    </li>
                    <li>
                      <strong>Version:</strong> <span class="text-secondary"><?= $_ENV['APPSYNC_API_VERSION']; ?></span>
                    </li>
                  </ul>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <h5>AppSync</h5>
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#aboutTechnicalModal">
              <div class="accordion-body">
                <ul>
                    <li>
                      <strong>Region:</strong> <span class="text-secondary"><?= $_ENV['APPSYNC_API_REGION']; ?></span>
                    </li>
                    <li>
                      <strong>Endpoint Address:</strong> <span class="text-primary"><?= $_ENV['APPSYNC_API_ENDPOINT']; ?></span>
                    </li>
                    <li>
                      <strong>API Key:</strong> <span class="text-secondary"><?= $utility->stringToSecret($_ENV['APPSYNC_API_KEY']); ?></span>
                    </li>
                    <li>
                      <strong>API ID:</strong> <span class="text-secondary"><?= $utility->stringToSecret($_ENV['APPSYNC_API_ID']); ?></span>
                    </li>
                    <li>
                      <strong>Version:</strong> <span class="text-secondary"><?= $_ENV['APPSYNC_API_VERSION']; ?></span>
                    </li>
                  </ul>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <h5>Logged-in User Info</h5>
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#aboutTechnicalModal">
              <div class="accordion-body">
                <ul>
                    <li>
                      <strong>Username:</strong> <span class="text-secondary"><?= session()->get("user")["Username"]; ?></span>
                    </li>
                    <li>
                      <strong>User Attributes:</strong>
                      <?php
                        $user_attributes = session()->get("user")["UserAttributes"];
                        foreach($user_attributes as $item) {
                      ?>
                          <?= $item["Name"] . ": "; ?><code><?= $item["Value"]; ?></code>
                      <?php
                        }
                      ?>
                    </li>
                    <li>
                      <strong>Enabled:</strong> <span class="text-secondary"><?= session()->get("user")["Enabled"] ? "True" : "False"; ?></span>
                    </li>
                    <li>
                      <strong>User Status:</strong> <span class="text-secondary"><?= session()->get("user")["UserStatus"]; ?></span>
                    </li>
                  </ul>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                <h5>Session Data</h5>
              </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#aboutTechnicalModal">
              <div class="accordion-body">
                <ul>
                    <li>
                      <strong><code>username</code></strong>: <span class="text-secondary"><?= session()->get("username"); ?></span>
                    </li>
                    <li>
                      <strong><code>userPoolId</code></strong>: <span class="text-secondary"><?= session()->get("userPoolId"); ?></span>
                    </li>
                    <li>
                      <strong><code>accessType</code></strong>: <span class="text-secondary"><?= session()->get("accessType"); ?></span>
                    </li>
                    <li>
                      <strong><code>_ci_previous_url</code></strong>: <span class="text-secondary"><?= session()->get("_ci_previous_url"); ?></span>
                    </li>
                    <li>
                      <strong><code>isLoggedIn</code></strong>: <span class="text-secondary"><?= session()->get("isLoggedIn") ? "True" : "False"; ?></span>
                    </li>
                    <li>
                      <strong><code><?= ACCESS_TOKEN_NAME; ?></code></strong>: <div class="text-wrap text-secondary text-break"  style="width: 60rem; font-size: 12px"><?= $utility->stringToSecret(session()->get("accessToken"), true); ?></div>
                    </li>
                    <li>
                      <strong><code><?= ID_TOKEN_NAME; ?></code></strong>: <div class="text-wrap text-secondary text-break"  style="width: 60rem; font-size: 12px"><?= $utility->stringToSecret(session()->get("idToken"), true); ?></div>
                    </li>
                  </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>