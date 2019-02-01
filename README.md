# RobotsOnTheInfiniteLine

Dva robota se postave na razlicitim mestima na beskonacnoj pravoj liniji. Kada se postave, svaki od njih izbaci malo ulja i napravi mrlju da bi oznacio startno mesto.

```
Left                             Robot                                     Robot                           Right

<-- -- -- -- -- -- -- -- -- -- -- *-- -- -- -- -- -- -- -- -- -- -- -- -- -*- -- -- -- -- -- -- -- -- -- ->  

* Mrlja od ulja
```

Roboti su programibilni i razumeju jednostavan programski jezik koji sadrzi samo cetiri instrukcije:
• Pomeri se jedno polje levo (instrukcija “L”)
• Pomeri se jedno polje desno (“R”)
• Preskoci sledecu instrukciju ako je ispod robota mrlja od ulja (“S”)
• GOTO instrukcija (“G”) koja sluzi da se izvrsavanja programa prebaci na neku instrukciju.

Napisati program koji ce dovesti do toga da se roboti u nekom trenutku sigurno sudare.
Roboti krecu istovremenu da izvrsavaju dati program, jednu instrukciju po sekundi.

Primer programa kojeg roboti razumeju:

```
loop:
L
L
S
R
G loop
```
