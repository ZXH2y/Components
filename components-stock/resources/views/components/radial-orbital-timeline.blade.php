@props([
    // $items = array of:
    // ['id'=>1,'title'=>'Planning','date'=>'Jan 2024','content'=>'...',
    //  'icon'=>'calendar','relatedIds'=>[2],'status'=>'completed','energy'=>100]
    'items' => [],
])

@php
    // icon key => heroicons-style SVG path
    $iconPaths = [
        'calendar' => 'M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M4.5 4.5h15A1.5 1.5 0 0121 6v13.5a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 19.5V6a1.5 1.5 0 011.5-1.5z',
        'file-text' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'code' => 'M9.75 6.75L4.5 12l5.25 5.25m4.5-10.5L19.5 12l-5.25 5.25',
        'user' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0',
        'clock' => 'M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'zap' => 'M13 2L3 14h7l-1 8 10-12h-7l1-8z',
        'link' => 'M13.5 10.5l3-3a3.182 3.182 0 114.5 4.5l-3 3m-9-1.5l-3 3a3.182 3.182 0 004.5 4.5l3-3M9 15l6-6',
        'arrow-right' => 'M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75',
    ];

    $statusLabel = [
        'completed' => 'COMPLETE',
        'in-progress' => 'IN PROGRESS',
        'pending' => 'PENDING',
    ];

    $statusClass = [
        'completed' => 'rot-badge--completed',
        'in-progress' => 'rot-badge--progress',
        'pending' => 'rot-badge--pending',
    ];
@endphp

<div
    x-data="radialOrbitalTimeline(@js($items))"
    x-init="init()"
    @click="handleContainerClick($event)"
    class="w-full h-screen flex flex-col items-center justify-center bg-black overflow-hidden relative"
>
    <div class="relative w-full max-w-4xl h-full flex items-center justify-center">
        <div
            class="absolute w-full h-full flex items-center justify-center"
            style="perspective:1000px;"
        >
            {{-- center pulsing core --}}
            <div class="absolute w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 via-blue-500 to-teal-500 animate-pulse flex items-center justify-center z-10">
                <div class="absolute w-20 h-20 rounded-full border border-white/20 animate-ping opacity-70"></div>
                <div class="absolute w-24 h-24 rounded-full border border-white/10 animate-ping opacity-50" style="animation-delay:.5s"></div>
                <div class="w-8 h-8 rounded-full bg-white/80 backdrop-blur-md"></div>
            </div>

            <div class="absolute w-96 h-96 rounded-full border border-white/10"></div>

            {{-- orbiting nodes --}}
            <template x-for="(item, index) in items" :key="item.id">
                <div
                    class="absolute transition-all duration-700 cursor-pointer"
                    :style="nodeStyle(item, index)"
                    @click.stop="toggleItem(item.id)"
                >
                    {{-- energy glow --}}
                    <div
                        class="absolute rounded-full -inset-1"
                        :class="pulseEffect[item.id] ? 'animate-pulse duration-1000' : ''"
                        :style="glowStyle(item)"
                    ></div>

                    {{-- node dot --}}
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300 transform"
                        :class="nodeDotClass(item)"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <template x-for="(paths, key) in iconPaths">
                                <path x-show="key === item.icon" stroke-linecap="round" stroke-linejoin="round" :d="paths"></path>
                            </template>
                        </svg>
                    </div>

                    {{-- label --}}
                    <div
                        class="absolute top-12 whitespace-nowrap text-xs font-semibold tracking-wider transition-all duration-300"
                        :class="expandedItems[item.id] ? 'text-white scale-125' : 'text-white/70'"
                        x-text="item.title"
                    ></div>

                    {{-- expanded card --}}
                    <div
                        x-show="expandedItems[item.id]"
                        x-cloak
                        @click.stop
                        class="absolute top-20 left-1/2 -translate-x-1/2 w-64 bg-black/90 backdrop-blur-lg border border-white/30 shadow-xl shadow-white/10 rounded-lg overflow-visible"
                    >
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-px h-3 bg-white/50"></div>
                        <div class="p-4 pb-2">
                            <div class="flex justify-between items-center">
                                <span
                                    class="px-2 py-0.5 text-xs font-semibold rounded-full border"
                                    :class="statusClass[item.status]"
                                    x-text="statusLabel[item.status]"
                                ></span>
                                <span class="text-xs font-mono text-white/50" x-text="item.date"></span>
                            </div>
                            <h3 class="text-sm mt-2 font-semibold text-white" x-text="item.title"></h3>
                        </div>
                        <div class="px-4 pb-4 text-xs text-white/80">
                            <p x-text="item.content"></p>

                            <div class="mt-4 pt-3 border-t border-white/10">
                                <div class="flex justify-between items-center text-xs mb-1">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-2.5 h-2.5 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" :d="iconPaths.zap"></path>
                                        </svg>
                                        Energy Level
                                    </span>
                                    <span class="font-mono" x-text="item.energy + '%'"></span>
                                </div>
                                <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500" :style="'width:' + item.energy + '%'"></div>
                                </div>
                            </div>

                            <template x-if="item.relatedIds && item.relatedIds.length > 0">
                                <div class="mt-4 pt-3 border-t border-white/10">
                                    <div class="flex items-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-2.5 h-2.5 text-white/70 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" :d="iconPaths.link"></path>
                                        </svg>
                                        <h4 class="text-xs uppercase tracking-wider font-medium text-white/70">Connected Nodes</h4>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        <template x-for="relatedId in item.relatedIds" :key="relatedId">
                                            <button
                                                type="button"
                                                @click.stop="toggleItem(relatedId)"
                                                class="flex items-center h-6 px-2 py-0 text-xs rounded-none border border-white/20 bg-transparent hover:bg-white/10 text-white/80 hover:text-white transition-all"
                                            >
                                                <span x-text="findItem(relatedId)?.title"></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-2 h-2 ml-1 text-white/60">
                                                    <path stroke-linecap="round" stroke-linejoin="round" :d="iconPaths['arrow-right']"></path>
                                                </svg>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    .rot-badge--completed { color:#fff; background:#000; border-color:#fff; }
    .rot-badge--progress  { color:#000; background:#fff; border-color:#000; }
    .rot-badge--pending   { color:#fff; background:rgba(0,0,0,.4); border-color:rgba(255,255,255,.5); }
</style>

<script>
    function radialOrbitalTimeline(items) {
        return {
            items: items,
            expandedItems: {},
            rotationAngle: 0,
            autoRotate: true,
            pulseEffect: {},
            activeNodeId: null,
            centerOffset: { x: 0, y: 0 },
            iconPaths: {
                calendar: '{{ $iconPaths['calendar'] }}',
                'file-text': '{{ $iconPaths['file-text'] }}',
                code: '{{ $iconPaths['code'] }}',
                user: '{{ $iconPaths['user'] }}',
                clock: '{{ $iconPaths['clock'] }}',
                zap: '{{ $iconPaths['zap'] }}',
                link: '{{ $iconPaths['link'] }}',
                'arrow-right': '{{ $iconPaths['arrow-right'] }}',
            },
            statusLabel: {
                completed: 'COMPLETE',
                'in-progress': 'IN PROGRESS',
                pending: 'PENDING',
            },
            statusClass: {
                completed: 'rot-badge--completed',
                'in-progress': 'rot-badge--progress',
                pending: 'rot-badge--pending',
            },

            init() {
                setInterval(() => {
                    if (this.autoRotate) {
                        this.rotationAngle = Number(((this.rotationAngle + 0.3) % 360).toFixed(3));
                    }
                }, 50);
            },

            findItem(id) {
                return this.items.find(i => i.id === id);
            },

            getRelatedItems(id) {
                const item = this.findItem(id);
                return item ? item.relatedIds : [];
            },

            isRelatedToActive(id) {
                if (!this.activeNodeId) return false;
                return this.getRelatedItems(this.activeNodeId).includes(id);
            },

            toggleItem(id) {
                const wasOpen = !!this.expandedItems[id];
                this.expandedItems = {};

                if (!wasOpen) {
                    this.expandedItems[id] = true;
                    this.activeNodeId = id;
                    this.autoRotate = false;

                    const newPulse = {};
                    this.getRelatedItems(id).forEach(relId => newPulse[relId] = true);
                    this.pulseEffect = newPulse;

                    this.centerViewOnNode(id);
                } else {
                    this.activeNodeId = null;
                    this.autoRotate = true;
                    this.pulseEffect = {};
                }
            },

            centerViewOnNode(id) {
                const index = this.items.findIndex(i => i.id === id);
                const total = this.items.length;
                const targetAngle = (index / total) * 360;
                this.rotationAngle = 270 - targetAngle;
            },

            calcPosition(index, total) {
                const angle = ((index / total) * 360 + this.rotationAngle) % 360;
                const radius = 200;
                const radian = (angle * Math.PI) / 180;
                const x = radius * Math.cos(radian) + this.centerOffset.x;
                const y = radius * Math.sin(radian) + this.centerOffset.y;
                const zIndex = Math.round(100 + 50 * Math.cos(radian));
                const opacity = Math.max(0.4, Math.min(1, 0.4 + 0.6 * ((1 + Math.sin(radian)) / 2)));
                return { x, y, zIndex, opacity };
            },

            nodeStyle(item, index) {
                const pos = this.calcPosition(index, this.items.length);
                const isExpanded = this.expandedItems[item.id];
                return `transform:translate(${pos.x}px,${pos.y}px);` +
                       `z-index:${isExpanded ? 200 : pos.zIndex};` +
                       `opacity:${isExpanded ? 1 : pos.opacity};`;
            },

            glowStyle(item) {
                const size = item.energy * 0.5 + 40;
                const offset = (size - 40) / 2;
                return `background:radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);` +
                       `width:${size}px;height:${size}px;left:-${offset}px;top:-${offset}px;`;
            },

            nodeDotClass(item) {
                const isExpanded = this.expandedItems[item.id];
                const isRelated = this.isRelatedToActive(item.id);
                return [
                    isExpanded ? 'bg-white text-black' : (isRelated ? 'bg-white/50 text-black' : 'bg-black text-white'),
                    isExpanded ? 'border-white shadow-lg shadow-white/30' : (isRelated ? 'border-white animate-pulse' : 'border-white/40'),
                    isExpanded ? 'scale-150' : '',
                ].join(' ');
            },

            handleContainerClick(e) {
                if (e.target === e.currentTarget) {
                    this.expandedItems = {};
                    this.activeNodeId = null;
                    this.pulseEffect = {};
                    this.autoRotate = true;
                }
            },
        };
    }
</script>