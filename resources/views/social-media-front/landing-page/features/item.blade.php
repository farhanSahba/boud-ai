<h5 @class([
    'm-0 bg-surface-background font-medium py-3 px-5 rounded-full text-lg/none inline-flex items-center gap-2 lg:whitespace-nowrap',
    'lg:self-start' => $loop->odd,
    'lg:self-end' => $loop->even,
])>
    <svg
        width="12"
        height="13"
        viewBox="0 0 12 13"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            d="M5.6401 12.4498C5.40768 11.1173 4.4625 9.44381 2.6651 8.09577C1.7819 7.42949 0.883203 6.99564 0 6.8097V6.15892C1.75091 5.74056 3.47083 4.56296 4.57096 2.96699C5.12878 2.16126 5.48516 1.37103 5.6401 0.549805H6.29089C6.5543 2.11478 7.76289 3.85019 9.40534 5.0123C10.2111 5.58561 11.0478 5.97298 11.9 6.15892V6.8097C10.1801 7.16608 8.18125 8.70006 7.18958 10.265C6.69375 11.0553 6.39935 11.7835 6.29089 12.4498H5.6401Z"
            fill="url(#paint0_linear_0_3332)"
        />
        <defs>
            <linearGradient
                id="paint0_linear_0_3332"
                x1="0"
                y1="6.4998"
                x2="11.9"
                y2="6.4998"
                gradientUnits="userSpaceOnUse"
            >
                <stop stop-color="#EB6434" />
                <stop
                    offset="0.545"
                    stop-color="#BB2D9F"
                />
                <stop
                    offset="0.98"
                    stop-color="#BB802D"
                />
            </linearGradient>
        </defs>
    </svg>
    {!! $item->title !!}
</h5>
