import {Component, Input, OnInit} from '@angular/core';

@Component({
  selector: 'app-total-loot',
  templateUrl: './total-loot.component.html',
  styleUrls: ['./total-loot.component.scss']
})
export class TotalLootComponent implements OnInit {
@Input() lootsPlayer : any;
  constructor() { }

  ngOnInit(): void {
  }
  countTotalLoot(){
    return this.lootsPlayer.length;
  }

}
