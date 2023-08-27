<!DOCTYPE html>
<html lang="en">

@include('layouts.admin.headerlink')

<body id="page-top">
    <!-- start: sidebar -->

    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.admin.sideber')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.admin.header')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('layouts.admin.footer')

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    @include('layouts.admin.footerlink')
</body>

</html>
