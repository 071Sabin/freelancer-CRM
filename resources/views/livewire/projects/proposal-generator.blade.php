<flux:modal name="ai-proposal-modal" class="w-full max-w-4xl !p-0 shadow-2xl rounded-2xl" lazy>
    <div class="flex flex-col max-h-[90vh] overflow-hidden">
        
        {{-- Header --}}
        <div class="px-6 pt-6 pb-5 border-b border-neutral-200 dark:border-neutral-750 shrink-0">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/20 text-purple-600 dark:text-purple-400">
                    <flux:icon.sparkles class="size-6" />
                </div>
                <div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                        AI Project Proposal Writer
                        <span class="inline-flex items-center rounded-md bg-purple-50 dark:bg-purple-400/10 px-2 py-0.5 text-xs font-semibold text-purple-700 dark:text-purple-400">Premium AI</span>
                    </h3>
                    <p class="text-xs text-neutral-500 mt-0.5">Generate high-converting project proposals and convert them directly to active project workspaces.</p>
                </div>
            </div>
        </div>

        {{-- Main Content - Split Grid --}}
        <div class="flex-1 overflow-y-auto p-6 sm:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- Form Controls (Left side) --}}
                <div class="lg:col-span-5 space-y-6">
                    <div>
                        <h4 class="text-sm font-semibold text-neutral-900 dark:text-white mb-4">Project Parameters</h4>
                        
                        <div class="space-y-4">
                            <flux:select wire:model="selectedClientId" label="Select Client" class="text-xs md:text-sm">
                                @foreach ($clients as $client)
                                    <flux:select.option value="{{ $client->id }}">
                                        {{ $client->client_name }} @if($client->company_name) ({{ $client->company_name }}) @endif
                                    </flux:select.option>
                                @endforeach
                            </flux:select>

                            <flux:textarea wire:model="projectConcept" 
                                label="Project Concept / Prompt" 
                                placeholder="Describe the project concept. E.g., 'E-commerce platform for flower delivery, modern design, includes cart, Stripe integration, and dashboard.'" 
                                rows="5" />

                            <div class="grid grid-cols-2 gap-4">
                                <x-input-field label="Est. Project Value" type="number" step="0.01" model="estimatedValue" required />
                                <x-input-field label="Hourly Rate" type="number" step="0.01" model="hourlyRate" required />
                            </div>
                        </div>
                    </div>

                    <flux:button wire:click="generateProposal" 
                        variant="filled" 
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white border-none shrink-0" 
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="generateProposal" class="flex items-center gap-1.5 justify-center">
                            <flux:icon.sparkles class="size-4" />
                            Generate Proposal
                        </span>
                        <span wire:loading wire:target="generateProposal" class="flex items-center gap-1.5 justify-center">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Writing Proposal...
                        </span>
                    </flux:button>
                </div>

                {{-- Preview Output (Right side) --}}
                <div class="lg:col-span-7 flex flex-col h-full min-h-[300px] border border-neutral-200 dark:border-neutral-700 rounded-xl bg-neutral-50/50 dark:bg-neutral-900/50 overflow-hidden">
                    <div class="px-4 py-3 bg-neutral-100 dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-750 flex items-center justify-between shrink-0">
                        <span class="text-xs font-bold uppercase tracking-wider text-neutral-500">AI Description Draft</span>
                        <span class="text-[10px] text-neutral-400">Plain Text Format</span>
                    </div>

                    <div class="flex-1 p-5 overflow-y-auto font-mono text-xs leading-relaxed max-h-[45vh] whitespace-pre-wrap select-all text-neutral-800 dark:text-neutral-200">
                        @if ($isGenerating)
                            <div class="flex flex-col items-center justify-center h-full py-12 text-center">
                                <svg class="animate-spin h-8 w-8 text-purple-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">AI is drafting your description...</p>
                                <p class="text-xs text-neutral-400 mt-1 max-w-[250px]">Generating a single-paragraph overview of your project concept.</p>
                            </div>
                        @elseif ($proposalMarkdown)
                            {{ $proposalMarkdown }}
                        @else
                            <div class="flex flex-col items-center justify-center h-full py-12 text-center text-neutral-400 dark:text-neutral-500">
                                <flux:icon.document-text class="size-12 mb-2 stroke-[1.5] text-neutral-300 dark:text-neutral-600" />
                                <p class="text-sm">Description output will appear here.</p>
                                <p class="text-xs max-w-[250px] mt-1">Configure parameters and hit generate to draft the project description using AI.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 bg-neutral-50 dark:bg-neutral-900/50 border-t border-neutral-200 dark:border-neutral-750 flex items-center justify-end gap-3 shrink-0">
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            
            <flux:button wire:click="createProjectFromProposal" 
                variant="filled" 
                class="bg-black hover:bg-neutral-800 text-white dark:bg-white dark:text-black border-none"
                >
                Create Project Workspace
            </flux:button>
        </div>

    </div>
</flux:modal>
