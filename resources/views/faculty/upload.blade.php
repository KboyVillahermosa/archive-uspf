<x-app-layout>
    <div class="min-h-screen bg-[#F3F2EF] py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-[#26225C] tracking-tight">Institutional Faculty Publication</h1>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-1">Professional Research Archive Submission</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('research.history') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-[10px] font-black text-gray-500 uppercase tracking-widest hover:bg-gray-50 transition shadow-sm">
                        Cancel Publication
                    </a>
                </div>
            </div>

            <form id="faculty-upload-form" method="POST" action="{{ route('faculty.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    <!-- Middle Column: Primary Submission Form -->
                    <main class="lg:col-span-8 space-y-4">
                        <!-- Core Metadata Card -->
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
                                <h2 class="text-[11px] font-black text-[#26225C] uppercase tracking-[0.2em]">Scientific Metadata</h2>
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Section 01</span>
                            </div>
                            
                            <div class="p-6 space-y-6">
                                <!-- Title -->
                                <div id="field-title">
                                    <label for="title" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2.5">Research Title <span class="text-rose-500">*</span></label>
                                    <input type="text" name="title" id="title" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#26225C]/10 focus:border-[#26225C] text-sm font-medium transition bg-gray-50/50"
                                        placeholder="Enter the scientific title of your publication..." value="{{ isset($editMode) && $editMode && isset($research) ? $research->title : old('title') }}">
                                    @error('title') <p class="text-rose-500 text-[10px] mt-2 font-black uppercase">{{ $message }}</p> @enderror
                                </div>

                                <!-- Co-Researchers -->
                                <div>
                                    <label for="co_researchers" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2.5">Authors / Co-Researchers <span class="text-rose-500">*</span></label>
                                    <input type="text" name="co_researchers" id="co_researchers" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#26225C]/10 focus:border-[#26225C] text-sm font-medium transition bg-gray-50/50"
                                        placeholder="Dr. John Doe, Prof. Jane Smith..." value="{{ isset($editMode) && $editMode && isset($research) ? $research->co_researchers : old('co_researchers') }}">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-2 ml-1 italic opacity-75">Separate multiple authors with commas</p>
                                    @error('co_researchers') <p class="text-rose-500 text-[10px] mt-2 font-black uppercase">{{ $message }}</p> @enderror
                                </div>

                                <!-- Department -->
                                <div id="field-department">
                                    <label for="department" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2.5">Institutional Department <span class="text-rose-500">*</span></label>
                                    <select name="department" id="department" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#26225C]/10 focus:border-[#26225C] text-sm font-medium transition bg-gray-50/50 appearance-none">
                                        <option value="">Select Department</option>
                                    </select>
                                    @error('department') <p class="text-rose-500 text-[10px] mt-2 font-black uppercase">{{ $message }}</p> @enderror
                                </div>

                                <!-- Abstract -->
                                <div id="field-abstract">
                                    <label for="abstract" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2.5">Scientific Abstract <span class="text-rose-500">*</span></label>
                                    <textarea name="abstract" id="abstract" rows="12" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#26225C]/10 focus:border-[#26225C] text-sm font-medium transition bg-gray-50/50 resize-none leading-relaxed"
                                        placeholder="Provide a comprehensive summary of your findings...">{{ isset($editMode) && $editMode && isset($research) ? $research->abstract : old('abstract') }}</textarea>
                                    <div class="flex items-center justify-between mt-2 px-1">
                                        <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest italic">300-400 word target</span>
                                        <span id="abstract-count" class="text-[9px] font-black text-gray-400 uppercase tracking-widest">0 words</span>
                                    </div>
                                    @error('abstract') <p class="text-rose-500 text-[10px] mt-2 font-black uppercase">{{ $message }}</p> @enderror
                                </div>

                                <!-- Keywords -->
                                <div>
                                    <label for="tags" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2.5">Indexing Keywords</label>
                                    <input type="text" name="tags" id="tags"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#26225C]/10 focus:border-[#26225C] text-sm font-medium transition bg-gray-50/50"
                                        placeholder="Keyword1, Keyword2..." value="{{ isset($editMode) && $editMode && isset($research) ? $research->tags : old('tags') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Citations Card -->
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
                                <h2 class="text-[11px] font-black text-[#26225C] uppercase tracking-[0.2em]">Citations & Network</h2>
                                <button type="button" id="add-citation-btn" class="text-[9px] font-black text-blue-600 uppercase tracking-widest hover:underline">+ Add Reference</button>
                            </div>
                            <div class="p-6">
                                <div id="citations-container" class="space-y-4">
                                    <div class="text-center py-4 text-gray-400 italic text-[10px] uppercase font-bold tracking-widest opacity-60">No linked institutional references</div>
                                </div>
                            </div>
                        </div>
                    </main>

                    <!-- Right Sidebar: Assets & Actions -->
                    <aside class="lg:col-span-4 space-y-4">
                        <!-- Mentor / Peer Review Search -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                            <h4 class="text-[10px] font-black text-[#26225C] uppercase tracking-[0.2em] mb-4">Lead Mentor / Sponsor</h4>
                            <div id="field-adviser" class="space-y-3">
                                <input type="text" id="adviser_search" placeholder="Search faculty name..." autocomplete="off"
                                    class="w-full px-3 py-2 border border-gray-200 rounded-md text-xs font-medium transition bg-gray-50/50">
                                <div id="adviser_results" class="absolute z-50 w-64 bg-white border border-gray-200 rounded-lg mt-1 max-h-40 overflow-y-auto hidden shadow-xl font-bold text-xs text-[#26225C]"></div>
                                <input type="hidden" name="adviser_id" id="adviser_id" value="{{ old('adviser_id') }}">
                                <div id="adviser_selected" class="hidden animate-fadeIn p-3 bg-purple-50 border border-purple-100 rounded-lg flex items-center justify-between">
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-black text-purple-900 truncate" id="adviser_name"></p>
                                        <p class="text-[8px] font-bold text-purple-400 truncate" id="adviser_email"></p>
                                    </div>
                                    <button type="button" onclick="clearAdviser()" class="text-gray-400 hover:text-rose-500 ml-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Asset Management -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-4">
                            <h4 class="text-[10px] font-black text-[#26225C] uppercase tracking-[0.2em]">Publication Assets</h4>
                            
                            <!-- Abstract PDF -->
                            <div id="field-abstract_file">
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Scientific Abstract</label>
                                <div class="upload-zone group border-[1.5px] border-dashed border-gray-200 rounded-lg p-4 text-center bg-gray-50/30 hover:bg-white hover:border-purple-500 transition-all cursor-pointer relative overflow-hidden">
                                    <input type="file" name="abstract_file" id="abstract_file" accept=".pdf" required class="hidden">
                                    <label for="abstract_file" class="cursor-pointer block">
                                        <p class="text-[10px] font-black text-[#26225C] truncate px-2">Select Abstract</p>
                                        <p class="text-[8px] text-gray-400 font-bold uppercase tracking-widest mt-1 opacity-60">PDF ONLY • 10MB</p>
                                    </label>
                                </div>
                            </div>

                            <!-- Research Paper -->
                            <div id="field-research_file">
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Full Manuscript</label>
                                <div class="upload-zone group border-[1.5px] border-dashed border-gray-200 rounded-lg p-4 text-center bg-gray-50/30 hover:bg-white hover:border-purple-500 transition-all cursor-pointer relative overflow-hidden">
                                    <input type="file" name="research_file" id="research_file" accept=".pdf" required class="hidden">
                                    <label for="research_file" class="cursor-pointer block">
                                        <p class="text-[10px] font-black text-[#26225C] truncate px-2">Select Manuscript</p>
                                        <p class="text-[8px] text-gray-400 font-bold uppercase tracking-widest mt-1 opacity-60">PDF ONLY • 10MB</p>
                                    </label>
                                </div>
                            </div>

                            <!-- Banner -->
                            <div id="field-banner_image">
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Presentation Banner</label>
                                <div class="upload-zone group border-[1.5px] border-dashed border-gray-200 rounded-lg aspect-[3/1] flex items-center justify-center bg-gray-50/30 hover:bg-white hover:border-purple-500 transition-all cursor-pointer relative overflow-hidden">
                                    <input type="file" name="banner_image" id="banner_image" accept="image/*" class="hidden">
                                    <label for="banner_image" class="cursor-pointer block w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="sticky bottom-6">
                            <button type="submit" class="w-full bg-[#26225C] hover:bg-[#342e7c] text-white py-4 px-6 rounded-xl transition-all font-black text-[11px] uppercase tracking-[0.2em] flex items-center justify-center gap-3 shadow-xl active:scale-[0.98] group">
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Publish Research
                            </button>
                            <p class="text-[9px] text-center text-gray-400 font-bold uppercase tracking-widest mt-4">Faculty Publication Review Active</p>
                        </div>
                    </aside>

                </div>
            </form>
        </div>
    </div>

    <!-- Scripts preserved and optimized -->
    <script>
        function scrollToField(fieldId) {
            const el = document.getElementById(`field-${fieldId}`);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                el.classList.add('ring-1', 'ring-purple-400');
                setTimeout(() => el.classList.remove('ring-1', 'ring-purple-400'), 2000);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadDepartments();
            updateProgress();
        });

        async function loadDepartments() {
            try {
                const r = await fetch('/api/departments');
                const data = await r.json();
                const sel = document.getElementById('department');
                sel.innerHTML = '<option value="">Select Department</option>';
                data.forEach(d => { sel.innerHTML += `<option value="${d.id}">${d.name}</option>`; });
            } catch (e) { console.error(e); }
        }

        document.getElementById('abstract').addEventListener('input', e => {
            const words = e.target.value.trim().split(/\s+/).filter(w => w.length > 0).length;
            document.getElementById('abstract-count').textContent = words + ' words';
            updateProgress();
        });

        ['title', 'co_researchers', 'department'].forEach(id => {
            const el = document.getElementById(id);
            if(el) el.addEventListener('input', updateProgress);
            if(el && el.tagName === 'SELECT') el.addEventListener('change', updateProgress);
        });

        function updateProgress() {
            let fields = ['title', 'co_researchers', 'department', 'abstract'];
            let filled = fields.filter(f => document.getElementById(f) && document.getElementById(f).value.trim() !== '').length;
            let percent = (filled / fields.length) * 100;
            const progress = document.getElementById('form-progress');
            if(progress) progress.style.width = percent + '%';
            
            const status = document.getElementById('submission-status');
            if (filled === fields.length && status) {
                status.textContent = 'Verified';
                status.className = 'text-green-600 bg-green-50 px-2 py-0.5 rounded';
            }
        }

        ['abstract_file', 'research_file', 'banner_image'].forEach(id => {
            const el = document.getElementById(id);
            if(!el) return;
            el.addEventListener('change', e => {
                if (e.target.files.length > 0) {
                    const zone = e.target.closest('.upload-zone');
                    zone.classList.add('border-green-500', 'bg-green-50/20');
                    if (id !== 'banner_image') {
                        zone.querySelector('p:first-of-type').textContent = e.target.files[0].name;
                    } else {
                        const reader = new FileReader();
                        reader.onload = r => { zone.innerHTML = `<img src="${r.target.result}" class="w-full h-full object-cover rounded shadow-sm">`; };
                        reader.readAsDataURL(e.target.files[0]);
                    }
                }
            });
        });

        const advIn = document.getElementById('adviser_search');
        if(advIn) {
            advIn.addEventListener('input', async e => {
                if (e.target.value.length < 3) return;
                const r = await fetch(`/api/faculty?search=${e.target.value}`);
                const data = await r.json();
                const res = document.getElementById('adviser_results');
                res.innerHTML = data.map(f => `<div class="p-2 hover:bg-gray-50 cursor-pointer border-b last:border-0" onclick="selAdv(${f.id},'${f.name.replace(/'/g,"\\'")}', '${f.email}')">${f.name}</div>`).join('');
                res.classList.remove('hidden');
            });
        }

        function selAdv(id, n, e) {
            document.getElementById('adviser_id').value = id;
            document.getElementById('adviser_name').textContent = n;
            document.getElementById('adviser_email').textContent = e;
            document.getElementById('adviser_selected').classList.remove('hidden');
            document.getElementById('adviser_results').classList.add('hidden');
            if(advIn) advIn.value = '';
        }

        function clearAdviser() {
            document.getElementById('adviser_id').value = '';
            document.getElementById('adviser_selected').classList.add('hidden');
        }

        let citCount = 0;
        document.getElementById('add-citation-btn').addEventListener('click', () => {
            const container = document.getElementById('citations-container');
            if (citCount === 0) container.innerHTML = '';
            citCount++;
            const div = document.createElement('div');
            div.className = 'p-4 border border-gray-100 rounded-lg bg-gray-50/50 relative';
            div.id = `cit-${citCount}`;
            div.innerHTML = `
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-3 right-3 text-gray-400 hover:text-red-500"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg></button>
                <div class="space-y-3">
                    <input type="text" id="cit-search-${citCount}" placeholder="Search Archive..." class="w-full px-3 py-2 border border-gray-200 rounded text-[10px] font-bold">
                    <div id="cit-res-${citCount}" class="absolute z-50 w-full bg-white border border-gray-200 rounded-md mt-1 max-h-32 overflow-y-auto hidden shadow-xl font-bold text-[10px]"></div>
                    <input type="hidden" id="cit-id-${citCount}" name="citations[${citCount}][research_id]">
                    <input type="hidden" id="cit-type-${citCount}" name="citations[${citCount}][research_type]">
                    <div id="cit-sel-${citCount}" class="hidden p-2 bg-blue-50 border border-blue-100 rounded text-[9px] font-black text-blue-900" id="cit-title-${citCount}"></div>
                </div>`;
            container.appendChild(div);
            setupCitSearch(citCount);
        });

        function setupCitSearch(id) {
            const input = document.getElementById(`cit-search-${id}`);
            const results = document.getElementById(`cit-res-${id}`);
            input.addEventListener('input', async e => {
                if (e.target.value.length < 3) return;
                const r = await fetch(`/citations/search?q=${e.target.value}`);
                const data = await r.json();
                results.innerHTML = data.map(i => `<div class="p-2 hover:bg-gray-50 cursor-pointer border-b" onclick="selectCit(${id},${i.id},'${i.type}','${i.title.replace(/'/g,"\\'")}')">${i.title}</div>`).join('');
                results.classList.remove('hidden');
            });
        }

        function selectCit(id, rid, type, title) {
            document.getElementById(`cit-id-${id}`).value = rid;
            document.getElementById(`cit-type-${id}`).value = type;
            const disp = document.getElementById(`cit-sel-${id}`);
            disp.textContent = `LINKED: ${title}`;
            disp.classList.remove('hidden');
            document.getElementById(`cit-res-${id}`).classList.add('hidden');
            document.getElementById(`cit-search-${id}`).value = '';
        }

        document.getElementById('faculty-upload-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<span class="animate-spin text-xs">◌</span> PUBLISHING...';
            
            try {
                const r = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                });
                const data = await r.json();
                
                if (data.status === 'success') {
                    await saveCits(data.research_id, 'faculty');
                    window.location.href = '{{ route("research.history") }}';
                } else {
                    let msg = data.message || 'Publication error. Please check all metrics.';
                    if (data.errors) msg = Object.values(data.errors).flat().join('\n');
                    alert(msg);
                    btn.disabled = false;
                    btn.innerHTML = 'Publish Research';
                }
            } catch (err) {
                alert('Connection error.');
                btn.disabled = false;
                btn.innerHTML = 'Publish Research';
            }
        });

        async function saveCits(rid, type) {
            const title = document.getElementById('title').value;
            const promises = [];
            
            document.querySelectorAll('[id^="cit-"]').forEach(el => {
                const cid = el.id.split('-')[1];
                if (!cid) return;
                const resIdEl = document.getElementById(`cit-id-${cid}`);
                if (!resIdEl) return;
                const resId = resIdEl.value;
                if (resId) {
                    promises.push(fetch('/citations', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({
                            citing_research_title: title,
                            citing_research_type: type,
                            citing_research_id: rid,
                            cited_research_id: resId,
                            cited_research_type: document.getElementById(`cit-type-${cid}`).value
                        })
                    }));
                }
            });
            
            return Promise.all(promises);
        }
    </script>
</x-app-layout>
