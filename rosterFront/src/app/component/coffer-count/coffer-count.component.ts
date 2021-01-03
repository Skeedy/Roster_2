import {Component, Input, OnInit} from '@angular/core';
import {Player} from '../../class/player';
import {Coffer} from "../../class/coffer";
import {Loot} from "../../class/loot";

@Component({
  selector: 'app-coffer-count',
  templateUrl: './coffer-count.component.html',
  styleUrls: ['./coffer-count.component.scss']
})
export class CofferCountComponent implements OnInit {
@Input() coffer: Coffer;
@Input() lootsPlayer: Loot[];
public count = 0;
  constructor() { }

  ngOnInit(): void {
    this.countCoffer();
  }
  countCoffer(){
    for(let i = 0 ; i<this.lootsPlayer.length; i++)
    if(this.coffer.id == this.lootsPlayer[i].item.id){
      this.count ++;
    }
  }
}
