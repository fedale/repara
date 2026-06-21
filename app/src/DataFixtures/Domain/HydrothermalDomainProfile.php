<?php

namespace App\DataFixtures\Domain;

/**
 * Domain profile for the "idrotermica sanitaria" field (heating, plumbing and
 * sanitary systems).
 */
final class HydrothermalDomainProfile implements DomainProfile
{
    public function key(): string
    {
        return 'idrotermica';
    }

    public function label(): string
    {
        return 'Idrotermica sanitaria';
    }

    public function projectActions(): array
    {
        return [
            'Manutenzione',
            'Installazione',
            'Ristrutturazione',
            'Ammodernamento',
            'Revisione',
            'Riqualificazione',
            'Adeguamento',
            'Sostituzione',
        ];
    }

    public function projectSubjects(): array
    {
        return [
            'impianto di climatizzazione',
            'centrale termica',
            'caldaia a condensazione',
            'rete idraulica',
            'impianto di riscaldamento a pavimento',
            'pompa di calore',
            'impianto solare termico',
            'rete di distribuzione acqua sanitaria',
            'sistema di trattamento acqua',
            'gruppo di pressurizzazione idrica',
            'impianto di ventilazione meccanica',
            'rete di scarico e sanitari',
        ];
    }

    public function taskActions(): array
    {
        return [
            'Sopralluogo',
            'Sostituzione',
            'Controllo',
            'Pulizia',
            'Collaudo',
            'Taratura',
            'Verifica',
            'Smontaggio',
            'Montaggio',
            'Riparazione',
            'Lubrificazione',
            'Sanificazione',
        ];
    }

    public function taskSubjects(): array
    {
        return [
            'filtro aria',
            'valvola di sicurezza',
            'pompa di circolazione',
            'scambiatore di calore',
            'gruppo di pressione',
            'sensore di temperatura',
            'guarnizioni',
            'bruciatore',
            'tubazioni acqua sanitaria',
            'vaso di espansione',
            'batteria di scambio',
            'addolcitore d\'acqua',
        ];
    }

    public function assetTypes(): array
    {
        return [
            'Climatizzazione',
            'Riscaldamento',
            'Produzione acqua calda sanitaria',
            'Idraulica e sanitari',
            'Trattamento acqua',
            'Solare termico',
            'Ventilazione',
            'Pompe e circolazione',
            'Regolazione e termoregolazione',
            'Accessori e ricambi',
        ];
    }

    public function assetBrands(): array
    {
        return [
            'Vaillant',
            'Ariston',
            'Baxi',
            'Beretta',
            'Ferroli',
            'Immergas',
            'Riello',
            'Daikin',
            'Fondital',
            'Caleffi',
        ];
    }

    public function assetEquipment(): array
    {
        return [
            'Caldaia a condensazione',
            'Caldaia murale a gas',
            'Pompa di calore aria-acqua',
            'Climatizzatore a parete',
            'Ventilconvettore fan coil',
            'Scaldabagno a gas',
            'Scaldabagno elettrico',
            'Bollitore ad accumulo',
            'Bruciatore a gas',
            'Pompa di circolazione',
            'Autoclave idrica',
            'Serbatoio di accumulo ACS',
            'Vaso di espansione',
            'Collettore solare termico',
            'Addolcitore d\'acqua',
            'Termostato ambiente',
            'Radiatore in alluminio',
            'Termoarredo da bagno',
        ];
    }

    public function assetModelSeries(): array
    {
        return [
            'EcoTherm',
            'EcoTherm Plus',
            'CondensLine',
            'CondensLine Pro',
            'Mynute Green',
            'Genia Air',
            'AquaPlus',
            'Hydro Inverter',
            'Thermo Compact',
            'Domina Condens',
            'Victrix Pro',
            'Perla Sensys',
            'BlueHelix Tech',
            'Power HT',
            'Idra Smart',
        ];
    }

    public function attachmentSubjects(): array
    {
        return [
            'Foto installazione caldaia',
            'Foto pompa di calore',
            'Foto collettore solare',
            'Foto gruppo termico',
            'Foto autoclave',
            'Foto impianto sanitario',
            'Targa dati caldaia',
            'Schema impianto idraulico',
            'Foto scaldabagno',
            'Foto bollitore',
        ];
    }
}
