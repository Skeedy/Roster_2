import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TotalLootComponent } from './total-loot.component';

describe('TotalLootComponent', () => {
  let component: TotalLootComponent;
  let fixture: ComponentFixture<TotalLootComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TotalLootComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TotalLootComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
