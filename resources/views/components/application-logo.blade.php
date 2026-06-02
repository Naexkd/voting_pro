<svg viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <!-- Outer rounded box (ballot box) -->
    <rect x="25" y="55" width="250" height="220" rx="20" ry="20" fill="currentColor" opacity="0.15"/>
    <rect x="25" y="55" width="250" height="220" rx="20" ry="20" fill="none" stroke="currentColor" stroke-width="6"/>

    <!-- Box slot on top -->
    <rect x="100" y="20" width="100" height="45" rx="10" ry="10" fill="currentColor" opacity="0.2"/>
    <rect x="100" y="20" width="100" height="45" rx="10" ry="10" fill="none" stroke="currentColor" stroke-width="5"/>
    <line x1="120" y1="42" x2="180" y2="42" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>

    <!-- Checkmark inside box -->
    <polyline points="95,160 135,200 205,120" fill="none" stroke="currentColor" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>

    <!-- Horizontal lines (paper lines) -->
    <line x1="75" y1="230" x2="225" y2="230" stroke="currentColor" stroke-width="4" stroke-linecap="round" opacity="0.5"/>
    <line x1="75" y1="248" x2="190" y2="248" stroke="currentColor" stroke-width="4" stroke-linecap="round" opacity="0.5"/>
</svg>
