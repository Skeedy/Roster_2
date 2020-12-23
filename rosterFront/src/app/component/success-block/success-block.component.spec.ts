import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SuccessBlockComponent } from './success-block.component';

describe('SuccessBlockComponent', () => {
  let component: SuccessBlockComponent;
  let fixture: ComponentFixture<SuccessBlockComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SuccessBlockComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SuccessBlockComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
