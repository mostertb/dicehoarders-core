<?php


namespace App\DataFixtures;


use App\Entity\Ability\Ability;
use App\Entity\Ability\AbilityGeneric;
use App\Entity\Ability\AbilityOverride;
use App\Entity\Item\BaseArmor;
use App\Entity\Item\BaseWeapon;
use App\Entity\Item\ItemAbility;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BaseItemFixtures extends Fixture implements FixtureGroupInterface
{

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['base_items'];
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getBaseArmors() as $armor) {
            $manager->persist($armor);
        }

        foreach ($this->getWeaponPropertiesAsAbilities() as $weaponProperties) {
            $manager->persist($weaponProperties);
        }

        $manager->flush();
    }

    private function getBaseArmors ()
    {
        $armors = [];

        $padded = new BaseArmor();
        $padded->setBaseItemName('Padded Armor');
        $padded->setClass(BaseArmor::CLASS_LIGHT_ARMOR);
        $padded->setCostCopper(500);
        $padded->setWeightPounds(8);
        $padded->setBaseAC(11);
        $padded->setMaxDexBonus(null);
        $padded->setOtherBonus(0);
        $padded->setStrRequirement(0);
        $padded->setStealthDisadvantage(true);
        $padded->setDonTimeTurns(10);
        $padded->setDoffTimeTurns(10);
        $armors[] = $padded;

        $leather = new BaseArmor();
        $leather->setBaseItemName('Leather Armor');
        $leather->setClass(BaseArmor::CLASS_LIGHT_ARMOR);
        $leather->setCostCopper(1000);
        $leather->setWeightPounds(10);
        $leather->setBaseAC(11);
        $leather->setMaxDexBonus(null);
        $leather->setOtherBonus(0);
        $leather->setStrRequirement(0);
        $leather->setStealthDisadvantage(false);
        $leather->setDonTimeTurns(10);
        $leather->setDoffTimeTurns(10);
        $armors [] = $leather;

        $studdedLeather = new BaseArmor();
        $studdedLeather->setBaseItemName('Studded Leather Armor');
        $studdedLeather->setClass(BaseArmor::CLASS_LIGHT_ARMOR);
        $studdedLeather->setCostCopper(4500);
        $studdedLeather->setWeightPounds(13);
        $studdedLeather->setBaseAC(12);
        $studdedLeather->setMaxDexBonus(null);
        $studdedLeather->setOtherBonus(0);
        $studdedLeather->setStrRequirement(0);
        $studdedLeather->setStealthDisadvantage(false);
        $studdedLeather->setDonTimeTurns(10);
        $studdedLeather->setDoffTimeTurns(10);
        $armors [] = $studdedLeather;

        $hide = new BaseArmor();
        $hide->setBaseItemName('Hide Armor');
        $hide->setClass(BaseArmor::CLASS_MEDIUM_ARMOR);
        $hide->setCostCopper(1000);
        $hide->setWeightPounds(12);
        $hide->setBaseAC(12);
        $hide->setMaxDexBonus(2);
        $hide->setOtherBonus(0);
        $hide->setStrRequirement(0);
        $hide->setStealthDisadvantage(false);
        $hide->setDonTimeTurns(50);
        $hide->setDoffTimeTurns(10);
        $armors [] = $hide;

        $chainShirt = new BaseArmor();
        $chainShirt->setBaseItemName('Chain Shirt');
        $chainShirt->setClass(BaseArmor::CLASS_MEDIUM_ARMOR);
        $chainShirt->setCostCopper(5000);
        $chainShirt->setWeightPounds(20);
        $chainShirt->setBaseAC(13);
        $chainShirt->setMaxDexBonus(2);
        $chainShirt->setOtherBonus(0);
        $chainShirt->setStrRequirement(0);
        $chainShirt->setStealthDisadvantage(false);
        $chainShirt->setDonTimeTurns(50);
        $chainShirt->setDoffTimeTurns(10);
        $armors [] = $chainShirt;

        $scaleMail = new BaseArmor();
        $scaleMail->setBaseItemName('Scale Mail');
        $scaleMail->setClass(BaseArmor::CLASS_MEDIUM_ARMOR);
        $scaleMail->setCostCopper(5000);
        $scaleMail->setWeightPounds(45);
        $scaleMail->setBaseAC(14);
        $scaleMail->setMaxDexBonus(2);
        $scaleMail->setOtherBonus(0);
        $scaleMail->setStrRequirement(0);
        $scaleMail->setStealthDisadvantage(true);
        $scaleMail->setDonTimeTurns(50);
        $scaleMail->setDoffTimeTurns(10);
        $armors [] = $scaleMail;

        $breastplate = new BaseArmor();
        $breastplate->setBaseItemName('Breastplate');
        $breastplate->setClass(BaseArmor::CLASS_MEDIUM_ARMOR);
        $breastplate->setCostCopper(40000);
        $breastplate->setWeightPounds(20);
        $breastplate->setBaseAC(14);
        $breastplate->setMaxDexBonus(2);
        $breastplate->setOtherBonus(0);
        $breastplate->setStrRequirement(0);
        $breastplate->setStealthDisadvantage(false);
        $breastplate->setDonTimeTurns(50);
        $breastplate->setDoffTimeTurns(10);
        $armors [] = $breastplate;

        $halfPlate = new BaseArmor();
        $halfPlate->setBaseItemName('Half Plate');
        $halfPlate->setClass(BaseArmor::CLASS_MEDIUM_ARMOR);
        $halfPlate->setCostCopper(75000);
        $halfPlate->setWeightPounds(40);
        $halfPlate->setBaseAC(15);
        $halfPlate->setMaxDexBonus(2);
        $halfPlate->setOtherBonus(0);
        $halfPlate->setStrRequirement(0);
        $halfPlate->setStealthDisadvantage(true);
        $halfPlate->setDonTimeTurns(50);
        $halfPlate->setDoffTimeTurns(10);
        $armors [] = $halfPlate;

        $ringMail = new BaseArmor();
        $ringMail->setBaseItemName('Ring Mail');
        $ringMail->setClass(BaseArmor::CLASS_HEAVY_ARMOR);
        $ringMail->setCostCopper(3000);
        $ringMail->setWeightPounds(40);
        $ringMail->setBaseAC(14);
        $ringMail->setMaxDexBonus(0);
        $ringMail->setOtherBonus(0);
        $ringMail->setStrRequirement(0);
        $ringMail->setStealthDisadvantage(true);
        $ringMail->setDonTimeTurns(100);
        $ringMail->setDoffTimeTurns(50);
        $armors [] = $ringMail;

        $chainMail = new BaseArmor();
        $chainMail->setBaseItemName('Chain Mail');
        $chainMail->setClass(BaseArmor::CLASS_HEAVY_ARMOR);
        $chainMail->setCostCopper(7500);
        $chainMail->setWeightPounds(55);
        $chainMail->setBaseAC(16);
        $chainMail->setMaxDexBonus(0);
        $chainMail->setOtherBonus(0);
        $chainMail->setStrRequirement(13);
        $chainMail->setStealthDisadvantage(true);
        $chainMail->setDonTimeTurns(100);
        $chainMail->setDoffTimeTurns(50);
        $armors [] = $chainMail;

        $splint = new BaseArmor();
        $splint->setBaseItemName('Splint Armor');
        $splint->setClass(BaseArmor::CLASS_HEAVY_ARMOR);
        $splint->setCostCopper(20000);
        $splint->setWeightPounds(60);
        $splint->setBaseAC(17);
        $splint->setMaxDexBonus(0);
        $splint->setOtherBonus(0);
        $splint->setStrRequirement(15);
        $splint->setStealthDisadvantage(true);
        $splint->setDonTimeTurns(100);
        $splint->setDoffTimeTurns(50);
        $armors [] = $splint;

        $plate = new BaseArmor();
        $plate->setBaseItemName('Plate Armor');
        $plate->setClass(BaseArmor::CLASS_HEAVY_ARMOR);
        $plate->setCostCopper(150000);
        $plate->setWeightPounds(65);
        $plate->setBaseAC(18);
        $plate->setMaxDexBonus(0);
        $plate->setOtherBonus(0);
        $plate->setStrRequirement(15);
        $plate->setStealthDisadvantage(true);
        $plate->setDonTimeTurns(100);
        $plate->setDoffTimeTurns(50);
        $armors [] = $plate;

        return $armors;
    }

    /** TODO Ammunition should probably be loaded before weapon properties */

    private function getWeaponPropertiesAsAbilities ()
    {
        $properties = [];

        $ammunitionDescription = 'You can use a weapon that has the ammunition property to make a ranged attack only if you have ammunition to fire from the weapon. Each time you attack with the weapon, you expend one piece of ammunition. Drawing the ammunition from a quiver, case, or other container is part of the attack (you need a free hand to load a one-handed weapon). At the end of the battle, you can recover half your expended ammunition by taking a minute to search the battlefield.'.PHP_EOL.'If you use a weapon that has the ammunition property to make a melee attack, you treat the weapon as an improvised weapon. A sling must be loaded to deal any damage when used in this way';

        $ammunitionArrows = new Ability();
        $abilityOverridesArrows = new AbilityOverride();
        $abilityOverridesArrows->setOverrideKey('ammunition');
        $abilityOverridesArrows->setValue('Arrow');
        $abilityGenericArrows = new AbilityGeneric();
        $abilityGenericArrows->setDescription($ammunitionDescription);
        $ammunitionArrows->setName('Ammunition - Arrows');
        $ammunitionArrows->setSlug(BaseWeapon::PROPERTY_AMMUNITION_ARROWS);
        $ammunitionArrows->setAbilityPartial([$abilityOverridesArrows, $abilityGenericArrows]);
        $properties [] = $ammunitionArrows;

        $ammunitionBolts = new Ability();
        $abilityOverridesBolts = new AbilityOverride();
        $abilityOverridesBolts->setOverrideKey('ammunition');
        $abilityOverridesBolts->setValue('Bolt');
        $abilityGenericBolts = new AbilityGeneric();
        $abilityGenericBolts->setDescription($ammunitionDescription);
        $ammunitionBolts->setName('Ammunition - Bolts');
        $ammunitionBolts->setSlug(BaseWeapon::PROPERTY_AMMUNITION_BOLTS);
        $ammunitionBolts->setAbilityPartial([$abilityOverridesBolts, $abilityGenericBolts]);
        $properties [] = $abilityOverridesBolts;

        return $properties;
    }
}
