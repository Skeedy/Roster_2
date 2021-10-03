import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Globals} from "../globals";
import {BehaviorSubject, Observable} from "rxjs";
import {Loot} from "../class/loot";
import {map} from "rxjs/operators";
import {Wishitem} from "../class/wishitem";
import {Coffer} from "../class/coffer";

@Injectable({
  providedIn: 'root'
})
export class LootService {
  public _lootsSub = new BehaviorSubject<Loot[]>(new Array<Loot>());
  public _loots: Observable<Loot[]>;
  public coffers = new Array<Coffer[]>();
  constructor(private http: HttpClient) {}

  getWeekLoot():Observable<Loot[]>{
    return this.http.get<Loot[]>(Globals.APP_API+ '/roster/currentWeekLoot').pipe(map((data) => {
      if (data ) {
        this._loots = this._lootsSub.asObservable();
        this._lootsSub.next(data);
      }
      return data;
    }));
  }
  refreshWeekLoot():Observable<Loot[]>{
    return this.http.get<Loot[]>(Globals.APP_API+ '/roster/currentWeekLoot').pipe(map((data) => {
      if (data ) {
        this._lootsSub.next(data);
      }
      return data;
    }));
  }
  sortByChest(chest, instanceId){
    return this._lootsSub.value.filter((loot:Loot)=>{
      return loot.chest === chest.toString() && loot.instance_id === instanceId.toString();
    })
  }
  sortByUpgrade(itemid, instanceId){
    return this._lootsSub.value.filter((loot:Loot)=>{
      return loot.item_id === itemid.toString() && loot.instance_id === instanceId.toString();
    })
  }
  getWeeks(){
    return this.http.get(Globals.APP_API+ '/roster/weeks')
  }
  getLootByWeek(value):Observable<Loot[]>{
    return this.http.get<Loot[]>(Globals.APP_API+ '/loot/week?week=' + value);
  }
  patchLoot(idLoot, idItem, idPlayerJob, instanceValue, chest){
    const obj = {
      id : idLoot? idLoot : null,
      playerjob_id : idPlayerJob,
      instance : instanceValue,
      chest : chest,
      item_id: idItem
    }
    console.log(obj);
    return this.http.patch(Globals.APP_API+ '/loot/', obj);
  }
  setItemToUpgrade(idLoot, idItem, idPlayerJob, idInstance, itemToUpgradeId){
    const obj = {
      id : idLoot? idLoot : null,
      playerjob_id : idPlayerJob,
      instance : idInstance,
      item_id: idItem,
      itemUpgrade: itemToUpgradeId
    }
    console.log(obj);
    return this.http.patch(Globals.APP_API+ '/loot/setupgrade', obj);
  }
  getCoffers():Observable<Coffer[]>{
    return this.http.get<Coffer[]>(Globals.APP_API+ '/loot/coffers');
  }
}
