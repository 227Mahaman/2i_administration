var availableTags = [
  "IAI",
  "Awendje",
  "Okala",
  "Beau-Sejour",
  "Plein Niger",
  "Nzeng Ayong",
  "Gare-routière",
  "Petit-pari",
  "PK6",
  "PK7",
  "PK8",
  "PK10",
  "PK11",
  "PK12",
  "BATAVIA",
  "NOMBAKELE",
  "LOUIS",
  "HAUT DE GUÉ GUÉ",
  "DERRIÈRE PRISON",
  "OSSENGHE",
  "CHARBONNAGES"
];
$( "#nom" ).autocomplete({
  source: availableTags
});