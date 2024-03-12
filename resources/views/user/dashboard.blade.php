<x-header title="User"/>

@dump(session('role'))

<div class="flex flex-col w-full h-full">
    <div class="w-full">
        <x-user.header/>
    </div>
    <div class="page-container">
        <div class="page-sidebar">
            <x-user.sidebar focusitem="Dashboard"/>
        </div>
        <div class="page-content">
            <div class="grid grid-cols-4 gap-4">
                @for ($i=0; $i < 10; $i++)
                    <div class="flex flex-col gap-2 p-2 bg-white border border-gray-200 shadow rounded">
                        <h2>stat title</h2>
                        <div class="w-full h-[150px] flex justify-center">
                            <svg viewBox="0 0 500 100" class="chart">
                                <polyline fill="none" stroke="#0074d9" stroke-width="2" points=" 00,120 20,60 40,80 60,20 80,80 100,80 120,60 140,100 160,90 180,80 200, 110 220, 10 240, 70 260, 100 280, 100 300, 40 320, 0 340, 100 360, 100 380, 120 400, 60 420, 70 440, 80 "/>
                            </svg>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<x-footer/>