<flux:modal name="modal-indeed" class="min-w-[96rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Vous avez Activé le Workflow</flux:heading>
            <flux:text class="mt-2">
                Vous avez bien activé le workflow en arrière-plan.<br>
                {{-- Pour scrapper les offres d'emploi sur Indeed... Vous pouvez consulter les offres
                <flux:link :href="route('offres-indeed')"><b>ICI</b></flux:link> --}}
                Cela peut prendre quelques minutes en fonction du nombre d'offres à traiter.
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="danger">FERMER</flux:button>
            </flux:modal.close>
            {{-- <flux:button type="submit" variant="danger">Delete project</flux:button> --}}
        </div>
    </div>
</flux:modal>
