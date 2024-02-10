<?php
  $utility = service('utility');
?>

<!-- Modal -->
<div class="modal fade" id="aboutTechnicalModal" tabindex="-1" aria-labelledby="aboutTechnicalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel"><strong>Technical Information (<span class="text-danger">Not for the normal user account!</span>)</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <ul class="nav nav-pills mb-3" id="technicalInfoTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab-btn" data-bs-toggle="tab" data-bs-target="#general-tab" type="button" role="tab" aria-controls="general-tab" aria-selected="true">General</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="stack-tab-btn" data-bs-toggle="tab" data-bs-target="#stack-tab" type="button" role="tab" aria-controls="stack-tab" aria-selected="false">Stack</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="session-tab-btn" data-bs-toggle="tab" data-bs-target="#session-tab" type="button" role="tab" aria-controls="session-tab" aria-selected="false">Session</button>
          </li>
        </ul>
        <div class="tab-content" id="technicalInfoTabContent">
          <div class="tab-pane fade show active" id="general-tab" role="tabpanel" aria-labelledby="general-tab">
            <div class="accordion" id="accordionGeneralAboutTechnical">
              <div class="accordion-item">
                <h2 class="accordion-header" id="generalTabAccordionHeadingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#generalTabAccordionCollapseOne" aria-expanded="false" aria-controls="generalTabAccordionCollapseOne">
                    <h5>Application</h5>
                  </button>
                </h2>
                <div id="generalTabAccordionCollapseOne" class="accordion-collapse collapse" aria-labelledby="generalTabAccordionHeadingOne" data-bs-parent="#accordionGeneralAboutTechnical">
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
            </div>
          </div>

          <div class="tab-pane fade" id="stack-tab" role="tabpanel" aria-labelledby="stack-tab">
            <div class="accordion" id="accordionStackAboutTechnical">
              <div class="accordion-item">
                <h2 class="accordion-header" id="stackTabAccordionHeadingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stackTabAccordionCollapseOne" aria-expanded="false" aria-controls="stackTabAccordionCollapseOne">
                    <h5>Cognito</h5>
                  </button>
                </h2>
                <div id="stackTabAccordionCollapseOne" class="accordion-collapse collapse" aria-labelledby="stackTabAccordionHeadingOne" data-bs-parent="#accordionStackAboutTechnical">
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
                <h2 class="accordion-header" id="stackTabAccordionHeadingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stackTabAccordionCollapseTwo" aria-expanded="false" aria-controls="stackTabAccordionCollapseTwo">
                    <h5>AppSync</h5>
                  </button>
                </h2>
                <div id="stackTabAccordionCollapseTwo" class="accordion-collapse collapse" aria-labelledby="stackTabAccordionHeadingTwo" data-bs-parent="#accordionStackAboutTechnical">
                  <div class="accordion-body">
                    <ul>
                        <li>
                          <strong>Region:</strong> <span class="text-secondary"><?= $_ENV['APPSYNC_API_REGION']; ?></span>
                        </li>
                        <li>
                          <strong>Endpoint Address:</strong> <span class="text-primary"><?= $_ENV['APPSYNC_API_ENDPOINT']; ?></span>
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
            </div>
          </div>

          <div class="tab-pane fade" id="session-tab" role="tabpanel" aria-labelledby="session-tab">
            <div class="accordion" id="accordionSessionAboutTechnical">
              <div class="accordion-item">
                  <h2 class="accordion-header" id="sessionTabAccordionHeadingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sessionTabAccordionCollapseOne" aria-expanded="false" aria-controls="sessionTabAccordionCollapseOne">
                      <h5>Logged-in User Info</h5>
                    </button>
                  </h2>
                  <div id="sessionTabAccordionCollapseOne" class="accordion-collapse collapse" aria-labelledby="sessionTabAccordionHeadingOne" data-bs-parent="#accordionSessionAboutTechnical">
                    <div class="accordion-body">
                      <ul>
                          <li>
                            <strong>Username:</strong> <span class="text-secondary"><?= session()->get("user")["Username"]; ?></span>
                          </li>
                          <li>
                            <strong>User Attributes:</strong>
                            <ol>
                              <?php
                                $user_attributes = session()->get("user")["UserAttributes"];
                                foreach($user_attributes as $item) {
                              ?>
                                  <li><?= $item["Name"] . ": "; ?><code><?= $item["Value"]; ?></code></li>
                              <?php
                                }
                              ?>
                            </ol>
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
                <h2 class="accordion-header" id="sessionTabAccordionHeadingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sessionTabAccordionCollapseTwo" aria-expanded="false" aria-controls="sessionTabAccordionCollapseTwo">
                    <h5>Session Data</h5>
                  </button>
                </h2>
                <div id="sessionTabAccordionCollapseTwo" class="accordion-collapse collapse" aria-labelledby="sessionTabAccordionHeadingTwo" data-bs-parent="#accordionSessionAboutTechnical">
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
                        <li>
                          <strong><code><?= REFRESH_TOKEN_NAME; ?></code></strong>: <div class="text-wrap text-secondary text-break"  style="width: 60rem; font-size: 12px"><?= $utility->stringToSecret(session()->get("refreshToken"), true); ?></div>
                        </li>
                      </ul>
                  </div>
                </div>
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