<?php


namespace App\Manager\Character;


use App\Entity\Character\Character;
use App\Entity\Character\CharacterItem;
use App\Entity\Item\Container;
use App\Entity\Item\Item;
use App\Entity\User\SfUser;
use App\ExceptionHandling\UserFriendlyException;
use App\Manager\Campaign\CampaignManager;
use App\Manager\Item\ItemManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;

class CharacterManager
{
    const PC_STATUS_ACTIVE = 1;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CampaignManager
     */
    private $campaignManager;

    /**
     * @var ItemManager
     */
    private $itemManager;

    public function __construct(EntityManagerInterface $entityManager, CampaignManager $campaignManager, ItemManager $itemManager)
    {
        $this->entityManager = $entityManager;
        $this->campaignManager = $campaignManager;
        $this->itemManager = $itemManager;
    }

    /**
     * @param SfUser $user
     * @param int $campaignJoinCode
     * @return Character
     * @throws UserFriendlyException
     */
    public function createCharacter ($user, $campaignJoinCode = null)
    {
        $character = new Character();
        $character->setUser($user);
        $character->setStatus(self::PC_STATUS_ACTIVE);
        $this->entityManager->persist($character);
        $this->entityManager->flush();

        if (!is_null($campaignJoinCode)) {
            $this->campaignManager->addCharacterToCampaignByJoinCode($character, $campaignJoinCode);
        }

        return $character;
    }


    /**
     * @param Item $item
     * @param Character $character
     * @param Container|null $holdingItem
     * @param int|null $count
     * @return CharacterItem
     * @throws UserFriendlyException
     */
    public function giveItemToCharacter (Item $item, Character $character, Container $holdingItem = null, int $count = null)
    {
        if (is_null($character->getCampaign())) {
            throw new UserFriendlyException('Character not part of a campaign');
        }

        if (!$this->itemManager->isValidItemForCampaign($character->getCampaign(), $item)) {
            throw new UserFriendlyException('Item does not belong to this campaign');
        }

        $characterItem = new CharacterItem();
        $characterItem->setItem($item);
        $characterItem->setCharacter($character);
        if (!empty($holdingItem)) {
            $characterItem->setHoldingItem($holdingItem);
        }
        if (!empty($count)) {
            if ($item->isCountable()) {
                $characterItem->setCount($count);
            } else {
                $this->giveItemToCharacter($item, $character, $holdingItem, --$count);
            }
        }

        $this->entityManager->persist($characterItem);
        $this->entityManager->flush();

        return $characterItem;
    }

    /**
     * @param CharacterItem $characterItem
     * @param CharacterItem $holdingItem
     * @throws UserFriendlyException
     */
    public function addCharacterItemToHoldingItem (CharacterItem $characterItem, CharacterItem $holdingItem) {
        if (! $holdingItem->getItem() instanceof Container) {
            throw new UserFriendlyException('Holding item is not a container');
        }

        if ($holdingItem->getCharacter()->getId() !== $characterItem->getCharacter()->getId()) {
            throw new UserFriendlyException('Holding item does not have same owner as item');
        }

        if (!$this->canAddItemToHoldingItem($characterItem->getItem(), $holdingItem, $characterItem->getCount())) {
            throw new UserFriendlyException('Can not add this item to holding item');
        }

        $characterItem->setHoldingItem($holdingItem);
        $this->entityManager->flush();
    }

    /**
     * @param Item $item
     * @param CharacterItem $holdingItem
     * @param int $count
     * @return bool
     * @throws UserFriendlyException
     */
    public function canAddItemToHoldingItem (Item $item, CharacterItem $holdingItem, $count = 1)
    {
        $itemArray = $this->itemManager->applyItemOverridesAsArray($item);
        $container = $holdingItem->getItem();

        if (!$container instanceof Container) {
            throw new UserFriendlyException('Holding item is not a container');
        }

        if (!is_null($container->getBaseItem()->getHoldSpecificBaseItem())) {
            /** TODO Allow for overrides */
            if ($container->getBaseItem()->getHoldSpecificBaseItem() !== $item->getBaseItem()->getBaseItemName()) {
                throw new UserFriendlyException('This holding item can only hold items of type '. $container->getBaseItem()->getHoldSpecificBaseItem());
            }

            /** TODO Complete */

        }


        return true;
    }

    /**
     * @param Character $character
     * @param Item|null $item
     * @return array
     * @throws \Exception
     */
    public function getCharacterContainers (Character $character, Item $item = null)
    {
        $response = [];

        $characterItems = $this->entityManager->getRepository(CharacterItem::class)->findBy(['character' => $character]);
        foreach ($characterItems as $characterItem) {
            if ($characterItem->getItem() instanceof Container) {
                if (!is_null($item) &&
                    !($characterItem->getItem()->getBaseItem()->getHoldSpecificBaseItem() === null
                        || $characterItem->getItem()->getBaseItem()->getHoldSpecificBaseItem() === $item->getBaseItem()->getBaseItemName())) {
                    continue;
                }
                $container = $this->itemManager->getItemAsObject($characterItem->getItem());

                $entry = [];
                $entry ['character_item_id'] = $characterItem->getId();
                $entry ['item_name'] = $container->getName();
                $entry ['container_holding_item_item_type'] = $container->getBaseItem()->getHoldSpecificBaseItem();
                $entry ['current_item_holding_weight'] = $this->getCharacterHoldingItemCarryingWeight($characterItem);
                $entry ['item_holding_weight'] = $container->getBaseItem()->getMaximumWeightPounds();
                $entry ['current_item_holding_count'] = $this->getCharacterHoldingItemCarryingCount($characterItem);
                $entry ['item_holding_count'] = $container->getBaseItem()->getMaximumSpecificItemNumber();

                $response [] = $entry;
            }
        }

        return $response;
    }

    /**
     * @param int $characterId
     * @return Character|object|null
     */
    public function getCharacterById (int $characterId)
    {
        return $this->entityManager->getRepository(Character::class)->find($characterId);
    }


    public function getCharacterHoldingItemCarryingWeight (CharacterItem $characterItem)
    {
        /**
         * TODO Do the gin tax
         */
        return 0;
    }

    public function getCharacterHoldingItemCarryingCount (CharacterItem $characterItem)
    {
        /**
         * TODO Do the gin tax
         */
        return 0;
    }
}
