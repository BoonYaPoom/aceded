<div class="metric-row">
    <div class="col-lg-12">
        <div class="metric-row metric-flush">
            <!-- metric column -->
            <div class="col">
                <!-- .metric -->

                <a @if ($role1) href="{{ route('UserManage', ['role' => $role1->role]) }}"
                @else
                href="" @endif
                    class="metric metric-bordered align-items-center">
                    <h2 class="metric-label"> ผู้ดูแลระบบ </h2>
                    <p class="metric-value h3">
                        <sub><i class="fas fa-user-cog fa-lg"></i> </sub> <span class="value ml-1">
                            {{ $count1 }}
                        </span>
                    </p>
                </a> <!-- /.metric -->
            </div><!-- /metric column -->
            <!-- metric column -->
            <div class="col">
                <!-- .metric -->
                <a @if ($role3) href="{{ route('UserManage', ['role' => $role3->role]) }}"
                @else
                href="" @endif
                    class="metric metric-bordered align-items-center">
                    <h2 class="metric-label"> ผู้สอน </h2>
                    <p class="metric-value h3">
                        <sub><i class="fas fa-user-tie fa-lg"></i> </sub> <span class="value ml-1">
                            {{ $count3 }}</span>
                    </p>
                </a> <!-- /.metric -->
            </div><!-- /metric column -->
            <!-- metric column -->
            <div class="col">
                <!-- .metric -->
                <a @if ($role4) href="{{ route('UserManage', ['role' => $role4->role]) }}"
                @else
                href="" @endif
                    class="metric metric-bordered align-items-center">
                    <h2 class="metric-label"> ผู้เรียน </h2>
                    <p class="metric-value h3">
                        <sub><i class="fas fa-user-graduate fa-lg"></i> </sub> <span class="value ml-1">
                            {{ $count4 }}</span>
                    </p>
                </a> <!-- /.metric -->
            </div><!-- /metric column -->
        </div>
    </div>
</div><!-- /metric row -->
