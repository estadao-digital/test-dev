    <!-- navbar -->
    <div data-ng-include=" 'app/shared/view/template/blocks/header.html'" class="app-header navbar">
    </div>
    <!-- / navbar -->

    <!-- menu -->
    <div data-ng-include=" 'app/shared/view/template/blocks/aside.php'" class="app-aside hidden-xs {{app.settings.asideColor}}">
    </div>
    <!-- / menu -->

    <!-- content -->
    <div class="app-content">
        <div data-ui-butterbar></div>
        <a href class="off-screen-toggle hide" data-ui-toggle-class="off-screen" data-target=".app-aside" ></a>
        <div data-ng-include="'app/shared/view/template/blocks/license-alert.html'"></div>
        <div class="app-content-body" data-ui-view></div>
    </div>
    <!-- /content -->

    <!-- footer -->
    <div class="app-footer wrapper b-t bg-light">
        <span class="pull-right ng-binding">{{app.settings.version}}
            <a href ui-scroll-to="app" class="m-l-sm text-muted">
                <i class="fa fa-long-arrow-up"></i>
            </a>
        </span>
    </div>
    <!-- / footer -->

<!--
    <div data-ng-include=" 'tpl/blocks/settings.html' " class="settings panel panel-default">
    </div>
-->
